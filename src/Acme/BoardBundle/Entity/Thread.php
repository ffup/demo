<?php

namespace Acme\BoardBundle\Entity;

class Thread
{
    const 
        ITEM_UNLOCKED = 0, 
        
        ITEM_LOCKED = 1,
        
        ITEM_MOVED = 2,
        
        POST_NORMAL = 0,
        
        POST_STICKY = 1, 
        
        POST_ANNOUNCE = 2,
        
        POST_GLOBAL = 3;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $status = 0;

    /**
     * @var integer
     */
    private $type = 0;

    /**
     * @var integer
     */
    private $numReplies = 0;

    /**
     * @var integer
     */
    private $numViews = 0;

    /**
     * @var integer
     */
    private $createdAt;

    /**
     * @var integer
     */
    private $updatedAt;

    /**
     * @var string
     */
    private $author;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Acme\BoardBundle\Entity\Comment
     */
    private $lastComment;

    /**
     * @var \Acme\BoardBundle\Entity\Comment
     */
    private $firstComment;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $commentTracks;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $comments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userTracks;

    /**
     * @var \Acme\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Acme\BoardBundle\Entity\Module
     */
    private $module;

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
     * Set title
     *
     * @param string $title
     * @return Thread
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Thread
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
     * Set numReplies
     *
     * @param integer $numReplies
     * @return Thread
     */
    public function setNumReplies($numReplies)
    {
        $this->numReplies = $numReplies;

        return $this;
    }

    /**
     * Get numReplies
     *
     * @return integer 
     */
    public function getNumReplies()
    {
        return $this->numReplies;
    }

    /**
     * Set numViews
     *
     * @param integer $numViews
     * @return Thread
     */
    public function setNumViews($numViews)
    {
        $this->numViews = $numViews;

        return $this;
    }

    /**
     * Get numViews
     *
     * @return integer 
     */
    public function getNumViews()
    {
        return $this->numViews;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Thread
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
     * @return Thread
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

    public function doStuffOnPrePersist()
    {
        $this->createdAt = time();
        $this->updatedAt = $this->createdAt;
    }
        
    /**
     * Set user
     *
     * @param \Acme\UserBundle\Entity\User $user
     * @return Thread
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
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add comment
     *
     * @param \Acme\BoardBundle\Entity\Comment $comment
     * @return Thread
     */
    public function addComment(\Acme\BoardBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;
        
        if ($this->numReplies == 0) {
            $this->setFirstComment($comment);        
        }
        
        $this->setLastComment($comment);
        $comment->setThread($this);
        
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Acme\BoardBundle\Entity\Comment $comments
     */
    public function removeComment(\Acme\BoardBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set module
     *
     * @param \Acme\BoardBundle\Entity\Module $module
     * @return Thread
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
     * Add userTracks
     *
     * @param \Acme\BoardBundle\Entity\ThreadTrack $userTracks
     * @return Thread
     */
    public function addUserTrack(\Acme\BoardBundle\Entity\ThreadTrack $userTracks)
    {
        $this->userTracks[] = $userTracks;

        return $this;
    }

    /**
     * Remove userTracks
     *
     * @param \Acme\BoardBundle\Entity\ThreadTrack $userTracks
     */
    public function removeUserTrack(\Acme\BoardBundle\Entity\ThreadTrack $userTracks)
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

    /**
     * Add commentTracks
     *
     * @param \Acme\BoardBundle\Entity\CommentTrack $commentTracks
     * @return Thread
     */
    public function addCommentTrack(\Acme\BoardBundle\Entity\CommentTrack $commentTracks)
    {
        $this->commentTracks[] = $commentTracks;

        return $this;
    }

    /**
     * Remove commentTracks
     *
     * @param \Acme\BoardBundle\Entity\CommentTrack $commentTracks
     */
    public function removeCommentTrack(\Acme\BoardBundle\Entity\CommentTrack $commentTracks)
    {
        $this->commentTracks->removeElement($commentTracks);
    }

    /**
     * Get commentTracks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentTracks()
    {
        return $this->commentTracks;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Thread
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Thread
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set lastComment
     *
     * @param \Acme\BoardBundle\Entity\Comment $lastComment
     * @return Thread
     */
    public function setLastComment(\Acme\BoardBundle\Entity\Comment $lastComment = null)
    {
        $this->lastComment = $lastComment;

        return $this;
    }

    /**
     * Get lastComment
     *
     * @return \Acme\BoardBundle\Entity\Comment 
     */
    public function getLastComment()
    {
        return $this->lastComment;
    }

    /**
     * Set firstComment
     *
     * @param \Acme\BoardBundle\Entity\Comment $firstComment
     * @return Thread
     */
    public function setFirstComment(\Acme\BoardBundle\Entity\Comment $firstComment = null)
    {
        $this->firstComment = $firstComment;

        return $this;
    }

    /**
     * Get firstComment
     *
     * @return \Acme\BoardBundle\Entity\Comment 
     */
    public function getFirstComment()
    {
        return $this->firstComment;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Thread
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
