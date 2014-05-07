<?php

namespace Acme\UserBundle\Security;

use Acme\UserBundle\Entity\User;
use Acme\UserBundle\Entity\UserManagerInterface;
use HWI\Bundle\OAuthBundle\Connect\AccountConnectorInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;

class OAuthUserProvider implements AccountConnectorInterface, OAuthAwareUserProviderInterface
{ 
    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @var array
     */
    protected $properties;

    /**
     * Constructor.
     *
     * @param UserManagerInterface $userManager FOSUB user provider.
     * @param array                $properties  Property mapping.
     */
    public function __construct(UserManagerInterface $userManager, array $properties)
    {
        $this->userManager = $userManager;
        $this->properties  = $properties;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        return $this->userManager->findUserByUsername($username);
    }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();
 
        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();
 
        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';
 
        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }
 
        //we connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());
 
        $this->userManager->updateUser($user);
    }
 
    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username = $response->getUsername();
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));
        //when the user is registrating
        if (null === $user) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set'.ucfirst($service);
            $setter_id = $setter.'Id';
            $setter_token = $setter.'AccessToken';
            // create new user here
            $user = $this->userManager->createUser();
            $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());
            //I have set all requested data with the user's username
            //modify here with relevant data
            // TODO
            $user->setUsername($service . '_' . $username);
            $user->setEmail($username);
            $user->setPassword($username);
            $this->userManager->updateUser($user);
            return $user;
        }
 
        //if user exists - go with the HWIOAuth way
        
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
 
        //update access token
        $user->$setter($response->getAccessToken());
        
        return $user;
    }
    
     /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Expected an instance of FOS\UserBundle\Model\User, but got "%s".', get_class($user)));
        }

        if (null === $reloadedUser = $this->userManager->findUserBy(array('id' => $user->getId()))) {
            throw new UsernameNotFoundException(sprintf('User with ID "%d" could not be reloaded.', $user->getId()));
        }

        return $user;
    }
    
    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $this->userManager->supportsClass($class);
    }
    
    /**
     * Gets the property for the response.
     *
     * @param UserResponseInterface $response
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function getProperty(UserResponseInterface $response)
    {
        $resourceOwnerName = $response->getResourceOwner()->getName();

        if (!isset($this->properties[$resourceOwnerName])) {
            throw new \RuntimeException(sprintf("No property defined for entity for resource owner '%s'.", $resourceOwnerName));
        }

        return $this->properties[$resourceOwnerName];
    }
}

