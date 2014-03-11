<?php
namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator as Pagination;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Null as PaginatorNullAdapter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ThreadController extends Controller
{

    public function indexAction(Request $request)
    {
        $pageSize = 10;
        $page = (int) $request->query->get('page', 1);
        $moduleId = $request->get('module_id');
   
        $em = $this->getDoctrine()->getManager();
        
        $module = $em->getRepository('AcmeBoardBundle:Module')->find((int) $moduleId);
        if ($page <= 0 || false == $module || false == $module->getIsDisplayed()) {
            throw new NotFoundHttpException();
        }
        
        $dql = "SELECT t FROM AcmeBoardBundle:Thread t
            WHERE t.module = :module ORDER BY t.updatedAt DESC";
        $query = $em->createQuery($dql)
            ->setParameter('module', $module)
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);
        
        $pagination = new Pagination($query);
        
        $paginator = new Paginator(new PaginatorNullAdapter($pagination->count()));
        $paginator->setItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page);
        
        $params = array(
            'module' => $module,
            'pages' => $paginator->getPages(),
            'pagination' => $pagination
        );
        
        return $this->render('AcmeBoardBundle:Thread:index.html.twig', $params);
    }

    public function createAction(Request $request)
    {
        $thread = new \Acme\BoardBundle\Entity\Thread();
        $form = $this->createForm(new \Acme\BoardBundle\Form\ThreadType(), $thread);
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        $module = $em->getRepository('AcmeBoardBundle:Module')->find((int) $request->query->get('module_id'));
        
        if (false == $module || false == $module->getIsEnabled()) {
            throw new NotFoundHttpException();
        }
        
        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $thread->setModule($module);
            // $this->container->get('security.context')->getToken()->getUser()
            $em->getRepository('AcmeBoardBundle:Thread')->create($this->getUser(), $thread);
            
            $this->get('session')
                ->getFlashBag()
                ->add('notice', 'Successfully created!');
            
            return $this->redirect($this->generateUrl('thread_index', array(
                'module_id' => $module->getId()
            )));
        }
        
        $params = array(
            'thread' => $thread,
            'form' => $form->createView(),
            'module' => $module
        );
        
        return $this->render('AcmeBoardBundle:Thread:create.html.twig', $params);
    }

    public function viewAction(Request $request)
    {
        $pageSize = 10;
        $page = (int) $request->query->get('page', 1);
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $thread = $em->getRepository('AcmeBoardBundle:Thread')->find($id);
        
        if ($page <= 0 || false == $thread) {
            throw new NotFoundHttpException();
        }
        
        $user = $this->getUser();
        $em->getRepository('AcmeBoardBundle:ThreadTrack')->create($user, $thread);
        
        // Pagnation    
        $offset = ($page - 1) * $pageSize;
        
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT c FROM AcmeBoardBundle:Comment c
            WHERE c.thread = :thread AND c.postIndex > :start AND c.postIndex < :end";
        $query = $em->createQuery($dql)
            ->setParameter('thread', $thread)
            ->setParameter('start', $offset)
            ->setParameter('end', $offset + $pageSize + 1);
        
        // $query->setResultCacheLifetime(60);
        
        $tracks = $em->getRepository('AcmeBoardBundle:CommentTrack')->findByUserAndThread($user, $thread);
        
        $trackIds = array_map(function ($track) {
                return $track->getComment()->getId();
            }, $tracks);
                   
        $pagination = $query->getResult();
        
        foreach ($pagination as $comment) {
            $comment->_hasVoted  = in_array($comment->getId(), $trackIds);
        }
        
        $paginator = new Paginator(new PaginatorNullAdapter($thread->getNumReplies() + 1));
        $paginator->setItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page); 
        // default 10
        // $paginator->setPageRange(10);
        
        $params = array(
            'thread' => $thread,
            'pages' => $paginator->getPages(),
            'pagination' => $pagination
        );

        return $this->render('AcmeBoardBundle:Thread:view.html.twig', $params);
    }
}
