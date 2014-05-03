<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CommentController extends Controller
{
    public function createAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $thread = $em->getRepository('AcmeBoardBundle:Thread')->find($id);
        
        if (! $thread) {
            throw new NotFoundHttpException;
        }
        
        $comment = new \Acme\BoardBundle\Entity\Comment();
        $comment->setThread($thread);
        
        $securityContext = $this->get('security.context');
        
        if (false === $securityContext->isGranted('CREATE', $comment)) {
            throw new AccessDeniedException('Unauthorised access!');
        }
        
        $formFactory = $this->container->get('acme_board.form_factory.comment');
        $form = $formFactory->createForm();
        $form->setData($comment);
        
        $form->handleRequest($request);

        if ($form->isValid()) {            
        
            $comment->setUser($this->getUser());                
            $em->getRepository('AcmeBoardBundle:Comment')->create($comment);

            // Notice
            $this->get('session')->getFlashBag()->add(
                'success',
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

    public function checkAction(Request $request)
    {
        // TODO
    }
}
