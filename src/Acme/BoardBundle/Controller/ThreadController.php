<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator as Pagination;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Null as PaginatorNullAdapter;

class ThreadController extends Controller
{
    public function indexAction(Request $request)
    {
        $page = $request->query->get('page', 1);;
        $moduleId = $request->get('module_id');
        $pageSize = 5;
        
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        
        $module = $em->getRepository('AcmeBoardBundle:Module')->find($moduleId);  
        
        $dql = "SELECT t, u FROM AcmeBoardBundle:Thread t JOIN t.user u
            WHERE t.module = :module ORDER BY t.updatedAt DESC";
        $query = $em->createQuery($dql)
            ->setParameter('module', $module)  
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);

        $pagination = new Pagination($query);
        
        $paginator = new Paginator(new PaginatorNullAdapter($pagination->count()));
        $paginator->setItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page);
        
        $params = array('module' => $module, 
            'pages' => $paginator->getPages(), 
            'pagination' => $pagination,);
        
        return $this->render('AcmeBoardBundle:Thread:index.html.twig', $params);
    }
    
    public function createAction(Request $request)
    {
        $thread = new \Acme\BoardBundle\Entity\Thread();   
        $form = $this->createForm(new \Acme\BoardBundle\Form\ThreadType(), $thread);
        $form->handleRequest($request);
        
        if ($form->isValid()) {        
            // perform some action, such as saving the task to the database       
            $em = $this->getDoctrine()->getManager();
            
            $module = $em->getRepository('AcmeBoardBundle:Module')
                ->find($request->query->get('module_id'));
            
            $thread->setModule($module);
            // $this->container->get('security.context')->getToken()->getUser()
            $em->getRepository('AcmeBoardBundle:Thread')
               ->create( $this->getUser(), $thread);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Successfully created!'
            );

            return $this->redirect($this->generateUrl('thread_index', 
                array('module_id' => $module->getId()))
            );
        }
        
        return $this->render('AcmeBoardBundle:Thread:create.html.twig', 
            array('form' => $form->createView()));
    }
    
    public function viewAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $thread = $em->getRepository('AcmeBoardBundle:Thread')->find($id);
        
        if (false == $thread) {
           throw new \Doctrine\ORM\NoResultException;
        }
              
        $user = $this->getUser();
        $em->getRepository('AcmeBoardBundle:ThreadTrack')->create($user, $thread);
             
        // Pagnation
        $page = $request->query->get('page', 1);
        $pageSize = 5;
    
        $offset =($page - 1) * $pageSize;    
        
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT c FROM AcmeBoardBundle:Comment c JOIN c.thread t
            WHERE c.thread = :thread AND c.postIndex > :start AND c.postIndex < :end";
        $query = $em->createQuery($dql)
            ->setParameter('thread', $thread)  
            ->setParameter('start', $offset)  
            ->setParameter('end', $offset + $pageSize + 1);           
        
        $ids = $em->getRepository('AcmeBoardBundle:CommentTrack')
            ->findByUserAndThread($user, $thread); 
            
        $pagination = $query->getResult();
        
        foreach ($pagination as $comment) {
            if (in_array($comment->getId(), $ids)) {
                $comment->_hasVoted = true;
            } else {
                $comment->_hasVoted = false;
            }
        }
                  
        $paginator = new Paginator(new PaginatorNullAdapter($thread->getNumReplies() + 1));
        $paginator->setItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page);// default 10
        // $paginator->setPageRange(10);
        
        $params = array('thread' => $thread, 
            'pages' => $paginator->getPages(), 
            'pagination' => $pagination,);
         // \Doctrine\Common\Util\Debug::dump($query);
  
        return $this->render('AcmeBoardBundle:Thread:view.html.twig', $params);
                
    }

}
