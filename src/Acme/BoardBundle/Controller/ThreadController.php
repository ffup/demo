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
        $pageSize = 5;
        
        $entityManager = $this->getDoctrine()->getManager();
        $dql = "SELECT t FROM AcmeBoardBundle:Thread t ORDER BY t.updatedAt DESC";
        $query = $entityManager->createQuery($dql)
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);

        // \Doctrine\Common\Util\Debug::dump($query);

        $pagination = new Pagination($query);
        
        $paginator = new Paginator(new PaginatorNullAdapter($pagination->count()));
        $paginator->setItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(10);
        // $offset = $paginator->getAbsoluteItemNumber($page) - 1;
        
        return $this->render('AcmeBoardBundle:Thread:index.html.twig', 
            array('pages' => $paginator->getPages(), 'pagination' => $pagination));
    }
    
    public function createAction(Request $request)
    {
        $thread = new \Acme\BoardBundle\Entity\Thread();
        
        $form = $this->createForm(new \Acme\BoardBundle\Form\ThreadType(), $thread);
        
        $form->handleRequest($request);
        $user = $this->getUser();
        
        if ($form->isValid()) {
            // perform some action, such as saving the task to the database       
            $em = $this->getDoctrine()->getManager();
            // $this->container->get('security.context')->getToken()->getUser()
            try {
                $em->getConnection()->beginTransaction(); // suspend auto-commit
                $thread->setUser($user);
                
                $em->persist($thread);
                $em->flush();
                
                $comment = new \Acme\BoardBundle\Entity\Comment();
                $comment->setUser($user)
                    ->setThread($thread)
                    ->setContent($thread->getContent())
                    ->setPostIndex(1);
                
                $em->persist($comment);
                $em->flush();
                
                $em->getConnection()->commit();     
            
            } catch(\Exception $e) {
                $em->getConnection()->rollback();
                $em->close();
                throw $e;
            }    

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Successfully created!'
            );

            return $this->redirect($this->generateUrl('_demo'));
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
           throw new \Exception('no id');
        }
        
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
        $paginator->setPageRange(10);
        
         // \Doctrine\Common\Util\Debug::dump($query);
        
        return $this->render('AcmeBoardBundle:Thread:view.html.twig', 
            array('thread' => $thread, 
                'pages' => $paginator->getPages(), 
                'pagination' => $pagination));
                
    }

}
