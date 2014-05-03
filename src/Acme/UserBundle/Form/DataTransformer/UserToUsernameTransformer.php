<?php

namespace Acme\UserBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Acme\UserBundle\Entity\User;
use Acme\UserBundle\Entity\UserManagerInterface;

class UserToUsernameTransformer implements DataTransformerInterface
{
    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Transforms an object (user) to a string (username).
     *
     * @param  User|null $user
     * @return string
     */
    public function transform($user)
    {
        if (null === $user) {
            return "";
        }

        return $user->getUsername();
    }

    /**
     * Transforms a string (username) to an object (user).
     *
     * @param  string $username
     *
     * @return User|null
     *
     * @throws TransformationFailedException if object (user) is not found.
     */
    public function reverseTransform($username)
    {
        if (!$username) {
            return null;
        }

        $user = $this->userManager->findUserByUsername($username);

        if (null === $user) {
            throw new TransformationFailedException(sprintf(
                'An user with username "%s" does not exist!',
                $username
            ));
        }

        return $user;
    }
}
