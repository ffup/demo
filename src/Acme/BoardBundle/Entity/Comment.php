<?php

namespace Acme\BoardBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Comment
{
    /**
     * @var integer
     */
    private $postIndex = 1;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $createdAt;

    /**
     * @var integer
     */
    private $updatedAt;

    /**
     * @var integer
     */
    private $votes = 0;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userTracks;

    /**
     * @var \Acme\BoardBundle\Entity\Thread
     */
    private $thread;

    /**
     * @var \Acme\UserBundle\Entity\User
     */
    private $user;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Comment
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Comment
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set user
     *
     * @param \Acme\UserBundle\Entity\User $user
     * @return Comment
     */
    public function setUser(\Acme\UserBundle\Entity\User $user = null)
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
     * @return Comment
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

    public function doStuffOnPrePersist()
    {
        $this->createdAt = time();
        $this->updatedAt = $this->createdAt;
    }
    

    /**
     * Set postIndex
     *
     * @param integer $postIndex
     * @return Comment
     */
    public function setPostIndex($postIndex)
    {
        $this->postIndex = $postIndex;

        return $this;
    }

    /**
     * Get postIndex
     *
     * @return integer 
     */
    public function getPostIndex()
    {
        return $this->postIndex;
    }
    
    public function getPostIndexPage($pageSize)
    {
        return (int)($this->postIndex / $pageSize + 1);
    }

    /**
     * Set votes
     *
     * @param integer $votes
     * @return Comment
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * Get votes
     *
     * @return integer 
     */
    public function getVotes()
    {
        return $this->votes;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userTracks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add userTracks
     *
     * @param \Acme\BoardBundle\Entity\CommentTrack $userTracks
     * @return Comment
     */
    public function addUserTrack(\Acme\BoardBundle\Entity\CommentTrack $userTracks)
    {
        $this->userTracks[] = $userTracks;

        return $this;
    }

    /**
     * Remove userTracks
     *
     * @param \Acme\BoardBundle\Entity\CommentTrack $userTracks
     */
    public function removeUserTrack(\Acme\BoardBundle\Entity\CommentTrack $userTracks)
    {
        $this->userTracks->removeElement($userTracks);
    }

    /**
     * Get userTracks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserTracks()
    {
        return $this->userTracks;
    }
}
