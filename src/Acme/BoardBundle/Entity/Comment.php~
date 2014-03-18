<?php

namespace Acme\BoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Comment
 *
 * @ORM\Table(name="comment", uniqueConstraints={@ORM\UniqueConstraint(columns={"thread_id", "post_index"})})
 * @ORM\Entity(repositoryClass="CommentRepository")
 * @ORM\HasLifecycleCallbacks() 
 */
class Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="post_index", type="integer")
     */
    private $postIndex;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=65535)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="votes", type="integer")
     */
    private $votes;    
    
    /**
     * @ORM\OneToMany(targetEntity="CommentTrack", mappedBy="comment")
     */      
    private $userTracks;
    
    /**
     * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)     
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Thread", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)     
     */
    protected $thread;

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
    
    /**
     * @ORM\PrePersist
     */
    public function doStuffOnPrePersist()
    {
        $this->createdAt = new \DateTime();
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
