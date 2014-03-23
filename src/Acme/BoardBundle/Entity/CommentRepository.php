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
        try {
            $this->_em->beginTransaction(); // suspend auto-commit
            $this->_em->lock($thread, LockMode::PESSIMISTIC_WRITE);
            // thread->numReplies ++;
            $thread->setNumReplies($thread->getNumReplies() + 1);
            
            $comment->setUser($user)
                ->setThread($thread)
                ->setPostIndex($thread->getNumReplies() +1);
            
            $thread->setLastComment($comment)
                ->setUpdatedAt(time());
            
            $this->_em->persist($thread);
            $this->_em->persist($comment);
                          
            $this->_em->flush();
            $this->_em->commit();     
        
        } catch(OptimisticLockException $e) {
            $this->_em->rollback();
            $this->_em->close();
            throw $e;
        }    
        
    }
    
    public function pagination($thread, $page, $pageSize)
    {
        $offset = ($page - 1) * $pageSize; 
        $dql = "SELECT c FROM AcmeBoardBundle:Comment c
            WHERE c.thread = :thread AND c.postIndex > :start AND c.postIndex < :end";
        $query = $this->_em->createQuery($dql)
            ->setParameter('thread', $thread->getId())
            ->setParameter('start', $offset)
            ->setParameter('end', $offset + $pageSize + 1);
        // $query->setResultCacheLifetime(60);
        return $query;
    }
    
    public function paginationWithTracks($user, Thread $thread, $page, $pageSize)
    {
        $pagination = $this->pagination($thread, $page, $pageSize)->getResult();
        $tracks = $this->_em->getRepository('AcmeBoardBundle:CommentTrack')->findByUserAndThread($user, $thread);
        
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
        $dql = "SELECT c, t FROM AcmeBoardBundle:Comment c JOIN c.thread t 
            WHERE c.user = :user";
        $query = $this->_em->createQuery($dql)
            ->setParameter('user', $user)
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);
            
        return $query;
    }
    
    public function countByUser($user)
    {
        $dql = "SELECT COUNT(c) FROM AcmeBoardBundle:Comment c
            WHERE c.user = :user";
        $query = $this->_em->createQuery($dql)
            ->setParameter('user', $user);
        
        return $query->getSingleScalarResult();
    }
    
}
