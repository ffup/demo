<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Acme\UserBundle\AcmeUserEvents;
use Acme\UserBundle\Event\FilterUserResponseEvent;
use Acme\UserBundle\Event\GetResponseUserEvent;
use Acme\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ChangePasswordController extends Controller
{
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();
        $formFactory = $this->container->get('acme_user.change_password.form.factory');
        $dispatcher = $this->container->get('event_dispatcher');
        
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(AcmeUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        
        $form = $formFactory->createForm();
        $form->setData($user);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $userManager = $this->container->get('user_manager');
            
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(AcmeUserEvents::CHANGE_PASSWORD_SUCCESS, $event);
            $userManager->updateUser($user);
            
            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('_signin');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(AcmeUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }
        
        return $this->render('AcmeUserBundle:ChangePassword:changePassword.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
