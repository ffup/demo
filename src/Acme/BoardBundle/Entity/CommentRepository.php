<?php

namespace Acme\BoardBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\OptimisticLockException;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends EntityRepository
{
    public function create(\Acme\UserBundle\Entity\User $user, Thread $thread, Comment $comment)
    {
        $em = $this->getEntityManager();

        try {
            $em->beginTransaction(); // suspend auto-commit
            $em->lock($thread, LockMode::PESSIMISTIC_WRITE);
            // thread->numReplies ++;
            $thread->setNumReplies($thread->getNumReplies() + 1);
            
            $comment->setUser($user);
            $comment->setThread($thread);
            $comment->setPostIndex($thread->getNumReplies() +1);
            $thread->setLastComment($comment);
            
            $em->persist($thread);
            $em->persist($comment);
                          
            $em->flush();
            $em->commit();     
        
        } catch(OptimisticLockException $e) {
            $em->rollback();
            $em->close();
            throw $e;
        }    
        
    }
    
    public function pagination($thread, $page, $pageSize)
    {
        $em = $this->getEntityManager();
        $offset = ($page - 1) * $pageSize; 
        $dql = "SELECT c FROM AcmeBoardBundle:Comment c
            WHERE c.thread = :thread AND c.postIndex > :start AND c.postIndex < :end";
        $query = $em->createQuery($dql)
            ->setParameter('thread', $thread->getId())
            ->setParameter('start', $offset)
            ->setParameter('end', $offset + $pageSize + 1);
        // $query->setResultCacheLifetime(60);
        return $query;
    }
    
    public function paginationWithTracks($user, Thread $thread, $page, $pageSize)
    {
        $pagination = $this->pagination($thread, $page, $pageSize)->getResult();
        $em = $this->getEntityManager();
        $tracks = $em->getRepository('AcmeBoardBundle:CommentTrack')->findByUserAndThread($user, $thread);
        
        $trackIds = array_map(function ($track) {
                return $track->getComment()->getId();
            }, $tracks);
                    
        foreach ($pagination as $comment) {
            $comment->_hasVoted  = in_array($comment->getId(), $trackIds);
        }
        
        return $pagination;
    }
    
    public function paginationByUser($user, $page, $pageSize)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT c, t FROM AcmeBoardBundle:Comment c JOIN c.thread t 
            WHERE c.user = :user";
        $query = $em->createQuery($dql)
            ->setParameter('user', $user)
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);
            
        return $query;
    }
    
    public function countByUser($user)
    {
        $em = $this->getEntityManager();
        $dql = "SELECT COUNT(c) FROM AcmeBoardBundle:Comment c
            WHERE c.user = :user";
        $query = $em->createQuery($dql)
            ->setParameter('user', $user);
        
        return $query->getSingleScalarResult();
    }
    
}
