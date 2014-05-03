<?php

namespace Acme\UserBundle\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;

interface SigninManagerInterface
{
    /**
     * @param string        $firewallName
     * @param UserInterface $user
     * @param Response|null $response
     *
     * @return void
     */
    public function signinUser($firewallName, UserInterface $user, Response $response = null);
}

