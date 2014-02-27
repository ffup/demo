<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ThreadController extends Controller
{
    public function indexAction()
    {
        // $threads = $this->getDoctrine()->getRepository('AcmeBoardBundle:Thread')->findAll();
            
        
        return $this->render('AcmeBoardBundle:Thread:index.html.twig', array());
    }
    
    public function createAction(Request $request)
    {
        $thread = new \Acme\BoardBundle\Entity\Thread();
        
        $form = $this->createForm(new \Acme\BoardBundle\Form\ThreadType(), $thread);
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action, such as saving the task to the database       
            $em = $this->getDoctrine()->getManager();
            // $this->container->get('security.context')->getToken()->getUser()
            
            $thread->setUser($this->getUser());
                              
            $em->persist($thread);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Successfully created!'
            );

            return $this->redirect($this->generateUrl('_demo'));
        }
        
        return $this->render('AcmeBoardBundle:Thread:create.html.twig', 
            array('form' => $form->createView()));
    }

}
