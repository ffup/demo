<?php

namespace Acme\BoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\OptimisticLockException;

class CommentController extends Controller
{
    public function createAction(Request $request)
    {

        $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $thread = $em->getRepository('AcmeBoardBundle:Thread')->find($id);
        
        // \Doctrine\Common\Util\Debug::dump($thread);
        
        if (!$thread) {
           throw new Exception('id is not exist!');
        }
        
        $comment = new \Acme\BoardBundle\Entity\Comment();
        $form = $this->createForm(new \Acme\BoardBundle\Form\CommentType(), $comment);
        $form->handleRequest($request);

        if ($form->isValid()) {            

            try {
                $em->getConnection()->beginTransaction(); // suspend auto-commit
                $em->lock($thread, LockMode::PESSIMISTIC_WRITE);
                // thread->numReplies ++;
                $thread->setNumReplies($thread->getNumReplies() + 1);
                $thread->setUpdatedAt(new \DateTime());
                
                $comment->setUser($this->getUser());
                $comment->setThread($thread);
                $comment->setPostIndex($thread->getNumReplies() +1);
                
                $em->persist($thread);
                $em->persist($comment);
                              
                $em->flush();
                $em->getConnection()->commit();     
            
            } catch(OptimisticLockException $e) {
                $em->getConnection()->rollback();
                $em->close();
                throw $e;
            }    

            // Notice
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Successfully created!'
            );

            return $this->redirect($this->generateUrl('thread_view', 
                array('id' => $thread->getId()))
            );
        }
        
        return $this->render('AcmeBoardBundle:Comment:create.html.twig', 
            array('form' => $form->createView()));
    
    }

}
