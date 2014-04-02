<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator as Pagination;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Null as PaginatorNullAdapter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ThreadController extends Controller
{

    public function indexAction(Request $request)
    {
        $pageSize = 20;
        $page = $request->query->get('page', 1);
        $moduleId = $request->get('module_id');
   
        $em = $this->getDoctrine()->getManager();
        // Lazy load
        $modules = $em->getRepository('AcmeBoardBundle:Module')->findAllModules();
        $module = $em->getRepository('AcmeBoardBundle:Module')->find($moduleId);
        
        if ($page < 1 || false === $this->get('security.context')->isGranted('VIEW', $module)) {
            throw new NotFoundHttpException();
        }
        
        $repo = $em->getRepository('AcmeBoardBundle:Thread');
        $query = $repo->pagination($module, $page, $pageSize);
        
        $pagination = $query->getResult();
        // $pagination = new Pagination($query);
        
        $paginator = new Paginator(new PaginatorNullAdapter($module->getNumThreads()));
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
        
        if (false === $this->get('security.context')->isGranted('CREATE', $thread)) {
            throw new AccessDeniedException('Unauthorised access!');
        }
        
        $form = $this->createForm(new \Acme\BoardBundle\Form\ThreadType(), $thread);
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        $module = $em->getRepository('AcmeBoardBundle:Module')->find($request->query->get('module_id'));
        
        if (false === $this->get('security.context')->isGranted('VIEW', $module)) {
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
        $pageSize = 20;
        $page = $request->query->get('page', 1);
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        
        $thread = $em->getRepository('AcmeBoardBundle:Thread')->find($id);
        
        if ($page < 1 || !$thread) {
            throw new NotFoundHttpException();
        }
        
        // if (false === $this->get('security.context')->isGranted('VIEW', $thread)) {
            // throw new AccessDeniedException('Unauthorised access!');
        // }
        
        $em->getRepository('AcmeBoardBundle:ThreadTrack')->create($this->getUser(), $thread);
        
        // Pagnation            
        $pagination = $em->getRepository('AcmeBoardBundle:Comment')
            ->paginationWithTracks($this->getUser(), $thread, $page, $pageSize);

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
    
    public function editAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $thread = $em->getRepository('AcmeBoardBundle:Thread')->find($id);
        
        if (false == $thread) {
            throw new NotFoundHttpException();
        }
        
        // keep in mind, this will call all registered security voters
        if (false === $this->get('security.context')->isGranted('EDIT', $thread)) {
            throw new AccessDeniedException('Unauthorised access!');
        }
        
        $module = $thread->getModule();
        $form = $this->createForm(new \Acme\BoardBundle\Form\ThreadType(), $thread);
        $form->handleRequest($request);
                
        if ($form->isValid()) {
            
            $comment = $thread->getFirstComment();
            $comment->setContent($thread->getContent());
            $thread->setFirstComment($comment);
            
            $em->persist($thread);
            $em->persist($comment);
            $em->flush(); 
            
            $this->get('session')
                ->getFlashBag()
                ->add('notice', 'Successfully updated!');
            
            return $this->redirect($this->generateUrl('thread_index', array(
                'module_id' => $module->getId(),
            )));
        }
        
        $params = array(
            'thread' => $thread,
            'form' => $form->createView(),
            'module' => $module
        );
        
        return $this->render('AcmeBoardBundle:Thread:edit.html.twig', $params);
    }
}
