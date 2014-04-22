<?php

namespace Acme\UserBundle\Event;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class UserEvent extends Event
{
    private $request;
    private $user;

    public function __construct(UserInterface $user, Request $request)
    {
        $this->user = $user;
        $this->request = $request;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}

