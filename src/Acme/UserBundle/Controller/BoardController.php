<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator as Pagination;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Null as PaginatorNullAdapter;

class BoardController extends Controller
{
    public function threadAction(Request $request)
    {
        $page = $request->query->get('page', 1);;
        $pageSize = 5;
        
        $entityManager = $this->getDoctrine()->getManager();
        $dql = "SELECT t FROM AcmeBoardBundle:Thread t WHERE t.user = :user
            ORDER BY t.updatedAt DESC";
        $query = $entityManager->createQuery($dql)
            ->setParameter('user', $this->getUser())  
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);
    
        $pagination = new Pagination($query);
        
        $paginator = new Paginator(new PaginatorNullAdapter($pagination->count()));
        $paginator->setItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page);
    
        $params = array('pages' => $paginator->getPages(), 'pagination' => $pagination);
        return $this->render('AcmeUserBundle:Board:thread.html.twig', $params);
    }

    public function commentAction(Request $request)
    {
    
        $page = $request->query->get('page', 1);;
        $pageSize = 5;
        
        $entityManager = $this->getDoctrine()->getManager();
        $dql = "SELECT c, t FROM AcmeBoardBundle:Comment c JOIN c.thread t 
            WHERE c.user = :user";
        $query = $entityManager->createQuery($dql)
            ->setParameter('user', $this->getUser())  
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);
    
        $pagination = new Pagination($query);
        
        $paginator = new Paginator(new PaginatorNullAdapter($pagination->count()));
        $paginator->setItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page);
        // $paginator->setPageRange(10);
    
        $params = array('pages' => $paginator->getPages(), 'pagination' => $pagination);
      

        return $this->render('AcmeUserBundle:Board:comment.html.twig', $params);
    }

}
