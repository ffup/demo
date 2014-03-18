<?php

namespace Acme\BoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ThreadTrack
 *
 * @ORM\Table(name="thread_track")
 * @ORM\Entity(repositoryClass="ThreadTrackRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ThreadTrack
{

    /** @ORM\Id @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="threadTracks") */
    private $user;
    
    /** @ORM\Id @ORM\ManyToOne(targetEntity="Thread", inversedBy="userTracks")) */
    private $thread;
    
    /**
     * @ORM\Column(name="has_viewed", type="boolean") 
     */
    private $hasViewed = false;
    
    /**
     * @ORM\Column(name="has_favored", type="boolean") 
     */    
    private $hasFavored = false;
    
    /** @ORM\ManyToOne(targetEntity="Module", inversedBy="threadTracks") @ORM\JoinColumn(nullable=false) */
    private $module;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;
    
   

    /**
     * Set hasViewed
     *
     * @param boolean $hasViewed
     * @return ThreadTrack
     */
    public function setHasViewed($hasViewed)
    {
        $this->hasViewed = $hasViewed;

        return $this;
    }

    /**
     * Get hasViewed
     *
     * @return boolean 
     */
    public function getHasViewed()
    {
        return $this->hasViewed;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ThreadTrack
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user
     *
     * @param \Acme\UserBundle\Entity\User $user
     * @return ThreadTrack
     */
    public function setUser(\Acme\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Acme\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set thread
     *
     * @param \Acme\BoardBundle\Entity\Thread $thread
     * @return ThreadTrack
     */
    public function setThread(\Acme\BoardBundle\Entity\Thread $thread)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \Acme\BoardBundle\Entity\Thread 
     */
    public function getThread()
    {
        return $this->thread;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function doStuffOnPrePersist()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Set module
     *
     * @param \Acme\BoardBundle\Entity\Module $module
     * @return ThreadTrack
     */
    public function setModule(\Acme\BoardBundle\Entity\Module $module = null)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \Acme\BoardBundle\Entity\Module 
     */
    public function getModule()
    {
        return $this->module;
    }
}
