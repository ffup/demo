<?php
namespace Acme\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\True as Recaptcha;
use Acme\UserBundle\Event\GetResponseUserEvent;
use Acme\UserBundle\AcmeUserEvents;

class SecuredController extends Controller
{
    public function signinAction(Request $request)
    {
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        $form = $this->createFormBuilder()
            ->add('recaptcha', 'ewz_recaptcha', 
                array(
                    'mapped' => false,
                    'constraints' => array(new Recaptcha()),
                )
            )
            ->getForm();

        $params = array(
            'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
            'form' => $form->createView(),
        );
        
        return $this->render('AcmeUserBundle:Secured:signin.html.twig', $params);
    }

    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    public function signoutAction()
    {
        // The security layer will intercept this request
    }

    public function signupAction(Request $request)
    {
        $userManager = $this->container->get('user_manager');
        $dispatcher = $this->container->get('event_dispatcher');
        $formFactory = $this->container->get('acme_user.registration.form.factory');
        
        $user = $userManager->createUser();
        
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(AcmeUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        // $form = $this->createForm(new \Acme\UserBundle\Form\Type\RegistrationType(), $user);
        $form = $formFactory->createForm();
        $form->setData($user);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            // TODO
            $em = $this->getDoctrine()->getManager();
            $role = $em->getRepository('AcmeUserBundle:Role')->findOneByRole('ROLE_USER');
            $user->addRole($role);
            
            $userManager->updateUser($user);                     
            // Notice
            $this->get('session')
                ->getFlashBag()
                ->add('notice', 'Successful registration!');
            
            // Here, "main" is the name of the firewall in your security.yml
            $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());
            $this->get('security.context')->setToken($token);
            
            return $this->redirect($this->generateUrl('module_index'));
        }
        
        return $this->render('AcmeUserBundle:Secured:signup.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
