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
        
        $entityManager = $this->getDoctrine()->getManager();
        
        $module = $entityManager->getRepository('AcmeBoardBundle:Module')
            ->findById($moduleId);  
        
        $dql = "SELECT t, u FROM AcmeBoardBundle:Thread t JOIN t.user u
            WHERE t.module = :module_id ORDER BY t.updatedAt DESC";
        $query = $entityManager->createQuery($dql)
            ->setParameter('module_id', $moduleId)  
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);

        $pagination = new Pagination($query);
        
        $paginator = new Paginator(new PaginatorNullAdapter($pagination->count()));
        $paginator->setItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page);
        // $offset = $paginator->getAbsoluteItemNumber($page) - 1;   
        $params = array('module' => $module, 
            'pages' => $paginator->getPages(), 
            'pagination' => $pagination);
        
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
                ->findById($request->query->get('module_id'));
            
            $thread->setModule($module);
            // $this->container->get('security.context')->getToken()->getUser()
            $em->getRepository('AcmeBoardBundle:Thread')
               ->create($thread, $this->getUser());

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
        
        if (!$thread) {
           throw new \Doctrine\ORM\NoResultException;
        }
        
        $module = $em->getRepository('AcmeBoardBundle:Module')
            ->findById($thread->getModule()->getId());  
        
        // Pagnation
        $page = $request->query->get('page', 1);
        $pageSize = 5;
    
        $offset =($page - 1) * $pageSize;
        
        $entityManager = $this->getDoctrine()->getManager();
        $dql = "SELECT c FROM AcmeBoardBundle:Comment c JOIN c.thread t
            WHERE t.id = :thread_id AND c.postIndex > :start AND c.postIndex < :end";
        $query = $entityManager->createQuery($dql)
            ->setParameter('thread_id', $id)  
            ->setParameter('start', $offset)  
            ->setParameter('end', $offset + $pageSize + 1);           
             
        $pagination = $query->getResult();
                
        $paginator = new Paginator(new PaginatorNullAdapter($thread->getNumReplies() + 1));
        $paginator->setItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page);
        // default 10
        // $paginator->setPageRange(10);
        
        $params = array('thread' => $thread, 
            'pages' => $paginator->getPages(), 
            'pagination' => $pagination,
            'module' => $module);
         // \Doctrine\Common\Util\Debug::dump($query);
        
        
        return $this->render('AcmeBoardBundle:Thread:view.html.twig', $params);
                
    }

}
