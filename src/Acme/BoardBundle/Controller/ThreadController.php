<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
        $moduleRepo = $em->getRepository('AcmeBoardBundle:Module');
        $modules = $moduleRepo->findAllModules();
        $module = $moduleRepo->find($moduleId);
        
        if ($page < 1 || false === $this->get('security.context')->isGranted('VIEW', $module)) {
            throw new NotFoundHttpException();
        }
        
        $query = $em->getRepository('AcmeBoardBundle:Thread')->pagination($module, $page, $pageSize);
        
        $pagination = $query->getResult();
        
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
        
        $securityContext = $this->get('security.context');
        if (false === $securityContext->isGranted('CREATE', $thread)) {
            throw new AccessDeniedException('Unauthorised access!');
        }
        
        $form = $this->createForm(new \Acme\BoardBundle\Form\ThreadType($securityContext), $thread);
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        $module = $em->getRepository('AcmeBoardBundle:Module')->find($request->get('module_id'));
        
        if (false === $securityContext->isGranted('VIEW', $module)) {
            throw new NotFoundHttpException();
        }
        
        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $thread->setModule($module)
                ->setUser($this->getUser());
            // $this->container->get('security.context')->getToken()->getUser()
            $em->getRepository('AcmeBoardBundle:Thread')->create($thread);
            
            $this->get('session')
                ->getFlashBag()
                ->add('success', 'Successfully created!');
            
            return $this->redirect($this->generateUrl('thread_index', array(
                'module_id' => $module->getId())
            ));
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
            ->pagination($thread, $page, $pageSize);

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
        $threadRepo = $em->getRepository('AcmeBoardBundle:Thread');
        
        $thread = $threadRepo->find($id);
        
        if (false == $thread) {
            throw new NotFoundHttpException();
        }
        
        $securityContext = $this->get('security.context');
        // keep in mind, this will call all registered security voters
        if (false === $securityContext->isGranted('EDIT', $thread)) {
            throw new AccessDeniedException('Unauthorised access!');
        }
        
        $module = $thread->getModule();
        
        $form = $this->createForm(new \Acme\BoardBundle\Form\ThreadType($securityContext), $thread);
        $form->handleRequest($request);
                
        if ($form->isValid()) {
            
            $threadRepo->update($thread);
                        
            $this->get('session')
                ->getFlashBag()
                ->add('success', 'Successfully updated!');
            
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
