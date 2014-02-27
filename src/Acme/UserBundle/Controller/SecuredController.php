<?php

namespace Acme\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/secured")
 */
class SecuredController extends Controller
{
    /**
     * @Route("/signin", name="_signin")
     * @Template()
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
            'error'         => $error,
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
     * @Route("/hello", defaults={"name"="World"}),
     * @Route("/hello/{name}", name="_secured_hello")
     * @Template()
     */
    public function helloAction($name)
    {
        return $this->render('AcmeUserBundle:Default:index.html.twig', array('name' => null));
    }

    /**
     * @Route("/hello/admin/{name}", name="_secured_hello_admin")
     * @Security("is_granted('ROLE_ADMIN')")
     * @Template()
     */
    public function helloadminAction($name)
    {
        return array('name' => $name);
    }
    
    /**
     * @Route("/signup", name="_signup")
     * @Template()
     */
    public function signupAction(Request $request)
    {
        
        $user = new \Acme\UserBundle\Entity\User();
        
        $form = $this->createForm(new \Acme\UserBundle\Form\UserType(), $user);
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Successful registration!'
            );

            return $this->redirect($this->generateUrl('_demo'));
        }
        
        return $this->render('AcmeUserBundle:Secured:signup.html.twig', 
            array('name' => null, 'form' => $form->createView()));
    }
}
