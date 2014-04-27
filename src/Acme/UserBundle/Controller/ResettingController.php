<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;
use Acme\UserBundle\Event\FormEvent;
use Acme\UserBundle\Event\GetResponseUserEvent;
use Acme\UserBundle\Event\FilterUserResponseEvent;
use Acme\UserBundle\AcmeUserEvents;

class ResettingController extends Controller
{
    public function requestAction(Request $request)
    {
        return $this->render('AcmeUserBundle:Resetting:request.html.twig', array());
    }
    
    /**
     * Request reset user password: submit form and send email
     */
    public function sendEmailAction(Request $request)
    {
        $username = $request->request->get('username', 'username');

        /** @var $user UserInterface */
        $userManager = $this->container->get('user_manager');
        $user = $userManager->findUserByUsernameOrEmail($username);
                
        if (null === $user) {
            return $this->render('AcmeUserBundle:Resetting:request.html.twig', array('invalid_username' => $username));
        }
        
        // \Doctrine\Common\Util\Debug::dump($user->getUsername());        exit;
        if ($user->isPasswordRequestNonExpired($this->container->getParameter('acme_user.resetting.token_ttl'))) {
            return $this->render('AcmeUserBundle:Resetting:passwordAlreadyRequested.html.twig');
        }
    
        if (null === $user->getConfirmationToken()) {
            /** @var $tokenGenerator \Acme\UserBundle\Util\TokenGeneratorInterface */
            $tokenGenerator = $this->container->get('acme_user.util.token_generator');
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }
        
        $this->container->get('acme_user.mailer')->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(time());
        $userManager->updateUser($user);

        return new RedirectResponse($this->generateUrl('resetting_check_email',
            array('email' => $this->getObfuscatedEmail($user))
        ));
    
        // return $this->render('AcmeUserBundle:Resetting:sendEmail.html.twig', array());        
    }
    
        /**
     * Tell the user to check his email provider
     */
    public function checkEmailAction(Request $request)
    {
        $email = $request->query->get('email');

        if (empty($email)) {
            // the user does not come from the sendEmail action
            return new RedirectResponse($this->generateUrl('resetting_request'));
        }

        return $this->render('AcmeUserBundle:Resetting:checkEmail.html.twig', 
            array('email' => $email,)
        );
    }
    
    /**
     * Reset user password
     */
    public function resetAction(Request $request, $token)
    {
        $userManager = $this->container->get('user_manager');
        
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(AcmeUserEvents::RESETTING_RESET_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        
        // $form = $formFactory->createForm();
        $form = $this->createForm(new \Acme\UserBundle\Form\ResettingFormType(), $user);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(AcmeUserEvents::RESETTING_RESET_SUCCESS, $event);

            // TODO
            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('user_profile');
                $response = new RedirectResponse($url);
            }
            
            $dispatcher->dispatch(AcmeUserEvents::RESETTING_RESET_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('AcmeUserBundle:Resetting:reset.html.twig', array(
            'token' => $token,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Get the truncated email displayed when requesting the resetting.
     *
     * The default implementation only keeps the part following @ in the address.
     *
     * @param UserInterface $user
     *
     * @return string
     */
    protected function getObfuscatedEmail(UserInterface $user)
    {
        $email = $user->getEmail();
        if (false !== $pos = strpos($email, '@')) {
            $email = '...' . substr($email, $pos);
        }

        return $email;
    }
}
