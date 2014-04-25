<?php

namespace Acme\BoardBundle\Entity;

class CommentTrack
{
    /**
     * @var boolean
     */
    private $hasVoted = false;

    /**
     * @var integer
     */
    private $createdAt;

    /**
     * @var \Acme\BoardBundle\Entity\Thread
     */
    private $thread;

    /**
     * @var \Acme\BoardBundle\Entity\Comment
     */
    private $comment;

    /**
     * @var \Acme\UserBundle\Entity\User
     */
    private $user;

    public function doStuffOnPrePersist()
    {
        $this->createdAt = time();
    }

    /**
     * Set hasVoted
     *
     * @param boolean $hasVoted
     * @return CommentTrack
     */
    public function setHasVoted($hasVoted)
    {
        $this->hasVoted = $hasVoted;

        return $this;
    }

    /**
     * Get hasVoted
     *
     * @return boolean 
     */
    public function getHasVoted()
    {
        return $this->hasVoted;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return CommentTrack
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
     * @return CommentTrack
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
     * Set comment
     *
     * @param \Acme\BoardBundle\Entity\Comment $comment
     * @return CommentTrack
     */
    public function setComment(\Acme\BoardBundle\Entity\Comment $comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return \Acme\BoardBundle\Entity\Comment 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set thread
     *
     * @param \Acme\BoardBundle\Entity\Thread $thread
     * @return CommentTrack
     */
    public function setThread(\Acme\BoardBundle\Entity\Thread $thread = null)
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
}
