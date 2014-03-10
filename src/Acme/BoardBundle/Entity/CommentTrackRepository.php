<?php

namespace Acme\BoardBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Acme\UserBundle\Entity\User;

/**
 * CommentTrackRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentTrackRepository extends EntityRepository
{

    public function findByUserAndComment(User $user, Comment $comment)
    {
        $em = $this->getEntityManager();
        $track = $em->getRepository('AcmeBoardBundle:CommentTrack')
            ->find(array(
                      'user' => $user->getId(),
                      'comment'  => $comment->getId(),
                      'thread'   => $comment->getThread()->getId(),
                  )
              );
              
        return $track;
    }
    
    public function create(User $user, Comment $comment)
    {
        $em = $this->getEntityManager();
        $track = new \Acme\BoardBundle\Entity\CommentTrack();
        $track->setUser($user)
              ->setComment($comment)
              ->setThread($comment->getThread())
              ->setHasVoted(true);
              
        $comment->setVotes($comment->getVotes() + 1);
        $em->persist($track);               
        $em->persist($comment);        
        $em->flush();
    }
    
    public function findByUserAndThread(User $user = null, Thread $thread)
    {
        $ids = array();
        
        if (!isset($user)) {
            return $ids;
        }
        
        $em = $this->getEntityManager();
        $dql = "SELECT c.id FROM AcmeBoardBundle:CommentTrack ct JOIN ct.comment c
            WHERE ct.user = :user AND ct.thread = :thread";
        $query = $em->createQuery($dql)
            ->setParameter('user', $user)
            ->setParameter('thread', $thread);  
        $tracks = $query->getResult();
                
        $ids = array_map(function ($v) { return $v['id'];}, $tracks);

        return $ids;
    }
}
