<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentController extends Controller
{

    public function createAction(Request $request)
    {
        $id = (int) $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $thread = $em->getRepository('AcmeBoardBundle:Thread')->find($id);
        
        if (! $thread) {
            throw new NotFoundHttpException;
        }
        
        $comment = new \Acme\BoardBundle\Entity\Comment();
        $form = $this->createForm(new \Acme\BoardBundle\Form\CommentType(), $comment);
        $form->handleRequest($request);

        if ($form->isValid()) {            
        
            $em->getRepository('AcmeBoardBundle:Comment')
               ->create($this->getUser(), $thread, $comment);

            // Notice
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Successfully created!'
            );

            return $this->redirect($this->generateUrl('thread_view', 
                array('id' => $thread->getId()))
            );
        }
        
        $params = array(
                      'form' => $form->createView(),
                      'thread' => $thread,
                  );
        return $this->render('AcmeBoardBundle:Comment:create.html.twig', $params);
    
    }

}
