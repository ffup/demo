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
        
        $form = $this->createForm(new \Acme\BoardBundle\Form\CommentType($securityContext), $comment);
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
        $pageSize = 10;
        $em = $this->getDoctrine()->getManager();
        
        $id = $request->request->get('id');
        $moduleId = $request->request->get('module_id');
        
        $dql = "SELECT t, c, u FROM AcmeBoardBundle:Comment c 
            JOIN c.user u JOIN c.thread t
            WHERE t.module = :module_id AND c.id > :id";
        $query = $em->createQuery($dql)
            ->setParameter('module_id', $moduleId)
            ->setParameter('id', $id)
            ->setMaxResults($pageSize);
            
        $res = $query->getArrayResult();
        
        // \Doctrine\Common\Util\Debug::dump($res);
        
        $response = new JsonResponse();
        $data = array(
            "code"    => 100, 
            "success" => true, 
            "comments" => $res,
        );   
           
        $response->setData($data);
        return $response;
        
        // TODO
    }
}
