<?php

namespace Acme\BoardBundle\Entity;

class ThreadTrack
{
   /**
     * @var boolean
     */
    private $hasViewed = false;

    /**
     * @var boolean
     */
    private $hasFavored = false;

    /**
     * @var integer
     */
    private $createdAt;

    /**
     * @var \Acme\BoardBundle\Entity\Module
     */
    private $module;

    /**
     * @var \Acme\BoardBundle\Entity\Thread
     */
    private $thread;

    /**
     * @var \Acme\UserBundle\Entity\User
     */
    private $user;

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
        $this->createdAt = time();
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

    /**
     * Set hasFavored
     *
     * @param boolean $hasFavored
     * @return ThreadTrack
     */
    public function setHasFavored($hasFavored)
    {
        $this->hasFavored = $hasFavored;

        return $this;
    }

    /**
     * Get hasFavored
     *
     * @return boolean 
     */
    public function getHasFavored()
    {
        return $this->hasFavored;
    }
}
