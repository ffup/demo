<?php

namespace Acme\UserBundle\EventListener;

use Acme\UserBundle\Event\FormEvent;
use Acme\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Acme\UserBundle\AcmeUserEvents;

class ResettingListener implements EventSubscriberInterface
{
    private $router;
    private $tokenTtl;

    public function __construct(UrlGeneratorInterface $router, $tokenTtl)
    {
        $this->router = $router;
        $this->tokenTtl = $tokenTtl;
    }

    public static function getSubscribedEvents()
    {
        return array(
            AcmeUserEvents::RESETTING_RESET_INITIALIZE => 'onResettingResetInitialize',
            AcmeUserEvents::RESETTING_RESET_SUCCESS => 'onResettingResetSuccess'
        );
    }

    public function onResettingResetInitialize(GetResponseUserEvent $event)
    {
        if (!$event->getUser()->isPasswordRequestNonExpired($this->tokenTtl)) {
            $event->setResponse(new RedirectResponse($this->router->generate('resetting_request')));
        }
    }

    public function onResettingResetSuccess(FormEvent $event)
    {
        $user = $event->getForm()->getData();

        $user->setConfirmationToken(null);
        $user->setPasswordRequestedAt(null);
    }
}

