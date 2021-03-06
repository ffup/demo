<?php

namespace Acme\BoardBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Acme\UserBundle\Entity\User;

/**
 * ThreadTrackRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ThreadTrackRepository extends EntityRepository
{
    public function create(User $user = null, Thread $thread)
    {
        if (!isset($user)) {
            return;
        }
    
        $track = $this->find(array(
            'user' => $user->getId(),
            'thread' => $thread->getId(),
        ));
                
        if (isset($track) && $track->getHasViewed()) {
            return;
        }
        
        $track = new ThreadTrack();
        $track->setUser($user)
              ->setThread($thread)
              ->setModule($thread->getModule())
              ->setHasViewed(true);
              
        $thread->setNumViews($thread->getNumViews() + 1);
        
        $this->_em->persist($thread);
        $this->_em->persist($track);
        $this->_em->flush();       
    }
}
