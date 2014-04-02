<?php

namespace Acme\BoardBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ModuleVoter implements VoterInterface
{
    const VIEW = 'VIEW';

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
            self::VIEW,
        ));
    }

    public function supportsClass($class)
    {
        $supportedClass = 'Acme\BoardBundle\Entity\Module';

        return $supportedClass === $class || is_subclass_of($class, $supportedClass);
    }

    /**
     * @var \Acme\BoardBundle\Entity\Module $module
     */
    public function vote(TokenInterface $token, $module, array $attributes)
    {
        // check if class of this object is supported by this voter
        if (!$this->supportsClass(get_class($module))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // check if the voter is used correct, only allow one attribute
        // this isn't a requirement, it's just one easy way for you to
        // design your voter
        if(1 !== count($attributes)) {
            throw new InvalidArgumentException(
                'Only one attribute is allowed for VIEW'
            );
        }

        // set the attribute to check against
        $attribute = $attributes[0];

        // get current logged in user
        $user = $token->getUser();

        // check if the given attribute is covered by this voter
        if (!$this->supportsAttribute($attribute)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // make sure there is a user object (i.e. that the user is logged in)
        if (!$user instanceof UserInterface) {
            // return VoterInterface::ACCESS_DENIED;
        }

        switch($attribute) {
            case 'VIEW':
                // the data object could have for example a method isPrivate()
                // which checks the Boolean attribute $private
                if ($module && ! $module->getEnableIndexing()) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;          
        }
    }
}
