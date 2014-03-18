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
        if ($page < 1 || false == $module || $module->getEnableIndexing()) {
            throw new NotFoundHttpException();
        }
        
        $query = $em->getRepository('AcmeBoardBundle:Thread')
            ->pagination($module, $page, $pageSize);
        
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
        
        if (false == $module || $module->getEnableIndexing()) {
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
        
        if ($page < 1 || false == $thread) {
            throw new NotFoundHttpException();
        }
        
        $user = $this->getUser();
        $em->getRepository('AcmeBoardBundle:ThreadTrack')->create($user, $thread);
        
        // Pagnation            
        $pagination = $em->getRepository('AcmeBoardBundle:Comment')
            ->paginationWithTracks($user, $thread, $page, $pageSize);

        $paginator = new Paginator(new PaginatorNullAdapter($thread->getNumReplies() + 1));
        $paginator->setItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page); 
        // $paginator->setPageRange(10);
        
        $params = array(
            'thread' => $thread,
            'pages' => $paginator->getPages(),
            'pagination' => $pagination
        );

        return $this->render('AcmeBoardBundle:Thread:view.html.twig', $params);
    }
}
