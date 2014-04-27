<?php

namespace Acme\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        $user = $this->findUserByUsernameOrEmail($username);

        if (!$user) {
            throw new UsernameNotFoundException(
                sprintf('Username "%s" does not exist.', $username)
            );
        }

        return $user;
    }
    
    public function findUserByUsernameOrEmail($usernameOrEmail)
    {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->findOneByEmail($usernameOrEmail);
        }

        return $this->findOneByUsername($usernameOrEmail);
    }
    
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->find($user->getId());
    }

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class
            || is_subclass_of($class, $this->getEntityName());
    }
    
    protected function getEncoder(UserInterface $user, EncoderFactoryInterface $encoderFactory)
    {
        return $encoderFactory->getEncoder($user);
    }
    
    public function updatePassword(UserInterface $user, EncoderFactoryInterface $encoderFactory)
    {
        if (0 !== strlen($password = $user->getPlainPassword())) {
            $encoder = $this->getEncoder($user, $encoderFactory);
            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
            $user->eraseCredentials();
        }
    }
    
    public function updateUser(UserInterface $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }
    
    public function create(UserInterface $user, EncoderFactoryInterface $encoderFactory)
    {
        trigger_error(sprintf('%s is deprecated. Extend Acme\UserBundle\Doctrine\UserManager directly.', __CLASS__), E_USER_DEPRECATED);

        $this->updatePassword($user, $encoderFactory);
        $role = $this->_em->getRepository('AcmeUserBundle:Role')->findOneByRole('ROLE_USER');
        $user->addRole($role);        
    }
}

