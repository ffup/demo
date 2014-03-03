<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    public function createAction(Request $request)
    {

        $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $thread = $em->getRepository('AcmeBoardBundle:Thread')->find($id);
        
        // \Doctrine\Common\Util\Debug::dump($thread);
        
        if (!$thread) {
           throw new Exception('id is not exist!');
        }
        
        $comment = new \Acme\BoardBundle\Entity\Comment();
        $form = $this->createForm(new \Acme\BoardBundle\Form\CommentType(), $comment);
        $form->handleRequest($request);

        if ($form->isValid()) {            
        
            $em->getRepository('AcmeBoardBundle:Comment')
              ->create($thread, $comment, $this->getUser());

            // Notice
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Successfully created!'
            );

            return $this->redirect($this->generateUrl('thread_view', 
                array('id' => $thread->getId()))
            );
        }
        
        return $this->render('AcmeBoardBundle:Comment:create.html.twig', 
            array('form' => $form->createView()));
    
    }

}