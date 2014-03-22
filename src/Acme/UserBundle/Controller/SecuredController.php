<?php
namespace Acme\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\True as Recaptcha;

/**
 * @Route("/secured")
 */
class SecuredController extends Controller
{

    /**
     * @Route("/signin", name="_signin")
     */
    public function signinAction(Request $request)
    {
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        $params = array(
            'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        );
        
        return $this->render('AcmeUserBundle:Secured:signin.html.twig', $params);
    }

    /**
     * @Route("/signin_check", name="_signin_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/signout", name="_signout")
     */
    public function signoutAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/signup", name="_signup")
     */
    public function signupAction(Request $request)
    {
        $user = new \Acme\UserBundle\Entity\User();
        $form = $this->createForm(new \Acme\UserBundle\Form\UserType(), $user);
        $form->add('recaptcha', 'ewz_recaptcha', 
            array(
                'mapped' => false,
                'constraints' => array(new Recaptcha()),
            )
        );
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);
            
            $em = $this->getDoctrine()->getManager();
            $role = $em->getRepository('AcmeUserBundle:Role')->findOneByRole('ROLE_USER');
            
            $user->addRole($role);
            $em->persist($user);
            $em->flush();
            
            // Notice
            $this->get('session')
                ->getFlashBag()
                ->add('notice', 'Successful registration!');
            
            // Here, "main" is the name of the firewall in your security.yml
            // $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());
            // $this->get('security.context')->setToken($token);
            
            return $this->redirect($this->generateUrl('_signin'));
        }
        
        return $this->render('AcmeUserBundle:Secured:signup.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function sendMailAction($user)
    {
        // Send Email
        $message = \Swift_Message::newInstance()->setSubject('Hello Email')
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody($this->renderView('AcmeDemoBundle:Demo:hello.html.twig', array(
            'name' => $user->getUsername()
        )));
        
        $this->get('mailer')->send($message);
    }
}
