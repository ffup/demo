<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MessageController extends Controller
{
    public function indexAction(Request $request)
    {
        $outbox = $this->getUser()->getSendMessages();
        $inbox = $this->getUser()->getReceiveMessages();
              
        $params = array(
            'inbox' => $inbox,
            'outbox' => $outbox,            
        );
        
        return $this->render('AcmeUserBundle:Message:index.html.twig', $params);
    }

    public function sendAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted(
            'IS_AUTHENTICATED_FULLY'
           )) {
            throw new AccessDeniedException();
        }
    
        $em = $this->getDoctrine()->getManager();    
        $message = new \Acme\UserBundle\Entity\Message();
        $form = $this->createForm(
            new \Acme\UserBundle\Form\MessageType(), $message, array('em' => $em));
            
        $form->handleRequest($request);
        /* $toUser = $em->getRepository('AcmeUserBundle:User')->find((int) $request->get('id'));
        if (false == $toUser) {
            throw new NotFoundHttpException();
        }
        */
        if ($form->isValid()) {
            
            $em->getRepository('AcmeUserBundle:Message')
                ->create($this->getUser(), $message);
            
            return $this->redirect($this->generateUrl('user_message'));
        }
        
        $params = array(
            'form' => $form->createView(),
        );
        
        return $this->render('AcmeUserBundle:Message:send.html.twig', $params);
    }
    
    public function readAction(Request $request)
    {
        $msgId = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AcmeUserBundle:Message');
        $msg = $repo->find($msgId);
        
        if (false == $msg) {
            throw new NotFoundHttpException();    
        }
        
        $repo->readByUser($this->getUser(), $msg);
        
        $params = array(
            'message' => $msg,
        );
        
        return $this->render('AcmeUserBundle:Message:read.html.twig', $params);
    }
    
    public function expAction(Request $request)
    {
        $pageSize = 10;
    
        $response = new JsonResponse();

        $inbox = $this->getUser()->getReceiveMessages();
        
        $totalRows = $inbox->count();
        $pageSize = $request->request->get('perPage', $pageSize);
        $page = $request->request->get('currentPage', 1);
        
        // TODO
        $sort = $request->request->get('sort', array(array('createdAt' => 'desc'),));
        $filter = $request->request->get('filter', array("column_0" => "foo"));

        $pagination = array(
          "totalRows"   => $totalRows,
          "perPage"     => $pageSize,
          "sort"        => $sort,
          "filter"      => $filter,
          "currentPage" => $page,
          "data"        => array(),
        );

        $offset = ($page - 1) * $pageSize;
        $part = $inbox->slice($offset, $pageSize);

        foreach ($part as $msg) {
            $pagination['data'][] = array(
                'title' => $msg->getTitle(),
                'content' => $msg->getContent(),
                'createdAt' => $msg->getCreatedAt(),                
            );
        }
            
        $response->setData($pagination);      
        return $response;
    }
    
}
