<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ChangePasswordController extends Controller
{
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(new \Acme\UserBundle\Form\ChangePasswordType(), $user);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $factory = $this->get('security.encoder_factory');
            $em = $this->getDoctrine()->getManager();
            $userRepo = $em->getRepository('AcmeUserBundle:User');            
            $userRepo->updatePassword($user, $factory);
            $userRepo->updateUser($user);
                        
            return $this->redirect($this->generateUrl('_signin'));
        }
        
        return $this->render('AcmeUserBundle:ChangePassword:changePassword.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
