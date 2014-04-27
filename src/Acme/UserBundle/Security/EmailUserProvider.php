<?php

namespace Acme\UserBundle\Security;

class EmailUserProvider extends UserProvider
{
    /**
     * {@inheritDoc}
     */
    protected function findUser($username)
    {
        return $this->userManager->findUserByUsernameOrEmail($username);
    }
}
