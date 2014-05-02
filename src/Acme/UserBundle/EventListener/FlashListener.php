<?php

namespace Acme\UserBundle\EventListener;

use Acme\UserBundle\AcmeUserEvents;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\TranslatorInterface;

class FlashListener implements EventSubscriberInterface
{
    private static $successMessages = array(
        AcmeUserEvents::CHANGE_PASSWORD_COMPLETED => 'change_password.flash.success',
        AcmeUserEvents::GROUP_CREATE_COMPLETED => 'group.flash.created',
        AcmeUserEvents::GROUP_DELETE_COMPLETED => 'group.flash.deleted',
        AcmeUserEvents::GROUP_EDIT_COMPLETED => 'group.flash.updated',
        AcmeUserEvents::PROFILE_EDIT_COMPLETED => 'profile.flash.updated',
        AcmeUserEvents::REGISTRATION_COMPLETED => 'registration.flash.user_created',
        AcmeUserEvents::RESETTING_RESET_COMPLETED => 'resetting.flash.success',
    );

    private $session;
    private $translator;

    public function __construct(Session $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    public static function getSubscribedEvents()
    {
        return array(
            AcmeUserEvents::CHANGE_PASSWORD_COMPLETED => 'addSuccessFlash',
            AcmeUserEvents::GROUP_CREATE_COMPLETED => 'addSuccessFlash',
            AcmeUserEvents::GROUP_DELETE_COMPLETED => 'addSuccessFlash',
            AcmeUserEvents::GROUP_EDIT_COMPLETED => 'addSuccessFlash',
            AcmeUserEvents::PROFILE_EDIT_COMPLETED => 'addSuccessFlash',
            AcmeUserEvents::REGISTRATION_COMPLETED => 'addSuccessFlash',
            AcmeUserEvents::RESETTING_RESET_COMPLETED => 'addSuccessFlash',
        );
    }

    public function addSuccessFlash(Event $event)
    {
        if (!isset(self::$successMessages[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message');
        }

        $this->session->getFlashBag()->add('success', $this->trans(self::$successMessages[$event->getName()]));
    }

    private function trans($message, array $params = array())
    {
        return $this->translator->trans($message, $params, 'AcmeUserBundle');
    }
}

