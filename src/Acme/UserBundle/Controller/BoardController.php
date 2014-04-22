<?php
namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator as Pagination;
use Doctrine\ORM\EntityRepository;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Null as PaginatorNullAdapter;

class BoardController extends Controller
{
    public function threadAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AcmeBoardBundle:Thread');
        
        $params = $this->pagination($request, $repo);
        return $this->render('AcmeUserBundle:Board:thread.html.twig', $params);
    }

    public function commentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AcmeBoardBundle:Comment');
        
        $params = $this->pagination($request, $repo);  
        return $this->render('AcmeUserBundle:Board:comment.html.twig', $params);
    }
    
    private function pagination(Request $request, EntityRepository $repo)
    {
        $pageSize = 20;
        $page = $request->query->get('page', 1);
        
        if ($page < 1) {
            throw new NotFoundHttpException();
        }
   
        $query = $repo->paginationByUser($this->getUser(), $page, $pageSize);
        
        $pagination = $query->getResult();
        // $pagination = new Pagination($query);
        
        $paginator = new Paginator(new PaginatorNullAdapter(
            $repo->countByUser($this->getUser())
        ));
        $paginator->setItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page);
        // $paginator->setPageRange(10);
        
        $params = array(
            'pages' => $paginator->getPages(),
            'pagination' => $pagination
        );
        
        return $params;
    }
}
