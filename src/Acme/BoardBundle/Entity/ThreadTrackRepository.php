<?php

namespace Acme\BoardBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ThreadTrackRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ThreadTrackRepository extends EntityRepository
{
    public function create(\Acme\UserBundle\Entity\User $user = null, Thread $thread)
    {
        if (!isset($user)) {
            return;
        }
    
        $em = $this->getEntityManager();
        $track = $em->getRepository('AcmeBoardBundle:ThreadTrack')
            ->find(array('user' => $user->getId(),
                'thread' => $thread->getId(),
                'module' => $thread->getModule()));
        if (isset($track) && $track->getHasViewed()) {
            return;
        }
        
        $track = new ThreadTrack();
        $track->setUser($user)
              ->setThread($thread)
              ->setModule($thread->getModule())
              ->setHasViewed(true);
              
        $thread->setNumViews($thread->getNumViews() + 1);
        
        $em->persist($thread);
        $em->persist($track);
        $em->flush();       
        
        // TODO 
        /*
        $dql = "SELECT t.id FROM AcmeBoardBundle:ThreadTrack tt JOIN tt.thread t
            WHERE tt.user = :user_id AND tt.hasViewed = true";
        $query = $entityManager->createQuery($dql)
            ->setParameter('user_id', $user->getId()); 
        $viewedIds = $query->getResult();
             
        \Doctrine\Common\Util\Debug::dump($viewedIds);
        */
 
    }

}