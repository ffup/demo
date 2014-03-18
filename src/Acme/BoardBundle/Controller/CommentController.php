<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    public function checkAction(Request $request)
    {
        $pageSize = 10;
        $em = $this->getDoctrine()->getManager();
        
        $id = (int) $request->query->get('id');
        $moduleId = (int) $request->query->get('module_id');
        
        $dql = "SELECT t, c FROM AcmeBoardBundle:Comment c 
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
        $params = array();
        return $this->render('AcmeBoardBundle:Default:index.html.twig', $params);
    }

}
