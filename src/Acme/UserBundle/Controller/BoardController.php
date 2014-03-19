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
        $pageSize = 20;
        $page = (int) $request->query->get('page', 1);
      
        if ($page < 1) {
            throw new NotFoundHttpException();
        }
        
        $interval = '-160 min';
        
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AcmeBoardBundle:Thread');
        $query = $repo->paginationByUser($this->getUser(), $page, $pageSize, $interval);
                    
        $pagination = $query->getResult();
        
        $paginator = new Paginator(new PaginatorNullAdapter(
            $repo->countByUser($this->getUser(), $interval)));
        $paginator->setItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page);
        
        $params = array(
            'pages' => $paginator->getPages(),
            'pagination' => $pagination
        );
        return $this->render('AcmeUserBundle:Board:thread.html.twig', $params);
    }

    public function commentAction(Request $request)
    {
        $pageSize = 20;
        $page = (int) $request->query->get('page', 1);
        
        if ($page < 1) {
            throw new NotFoundHttpException();
        }
   
        $em = $this->getDoctrine()->getManager();
        $resp = $em->getRepository('AcmeBoardBundle:Comment');
          
        $query = $resp->paginationByUser($this->getUser(), $page, $pageSize);
        
        $pagination = $query->getResult();
        // $pagination = new Pagination($query);
        
        $paginator = new Paginator(new PaginatorNullAdapter(
            $resp->countByUser($this->getUser())));
        $paginator->setItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page);
        // $paginator->setPageRange(10);
        
        $params = array(
            'pages' => $paginator->getPages(),
            'pagination' => $pagination
        );
        
        return $this->render('AcmeUserBundle:Board:comment.html.twig', $params);
    }
}
