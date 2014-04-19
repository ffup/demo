<?php

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
 
class SessionListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
            return;
        }
 
        $session = $event->getRequest()->getSession();
        $metadataBag = $session->getMetadataBag();
 
        $lastUsed = $metadataBag->getLastUsed();
        if ($lastUsed === null) {
            // the session was created just now
            return;
        }
 
        // "last used" is a Unix timestamp
 
        // if a session is being revived after too many seconds:
        $session->invalidate();
    }
}

