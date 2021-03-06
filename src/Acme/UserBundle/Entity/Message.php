<?php

namespace Acme\UserBundle\Entity;

class Message
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var boolean
     */
    private $hasRead = false;

    /**
     * @var integer
     */
    private $createdAt;

    /**
     * @var integer
     */
    private $type = 0;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Acme\UserBundle\Entity\User
     */
    private $fromUser;

    /**
     * @var \Acme\UserBundle\Entity\User
     */
    private $toUser;
    
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
     * @return Message
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
     * @return Message
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
     * Set hasRead
     *
     * @param boolean $hasRead
     * @return Message
     */
    public function setHasRead($hasRead)
    {
        $this->hasRead = $hasRead;

        return $this;
    }

    /**
     * Get hasRead
     *
     * @return boolean 
     */
    public function getHasRead()
    {
        return $this->hasRead;
    }

    /**
     * Set createdAt
     *
     * @param integer $createdAt
     * @return Message
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return integer 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Message
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
     * Set toUser
     *
     * @param \Acme\UserBundle\Entity\User $toUser
     * @return Message
     */
    public function setToUser(\Acme\UserBundle\Entity\User $toUser)
    {
        $this->toUser = $toUser;

        return $this;
    }

    /**
     * Get toUser
     *
     * @return \Acme\UserBundle\Entity\User 
     */
    public function getToUser()
    {
        return $this->toUser;
    }

    /**
     * Set fromUser
     *
     * @param \Acme\UserBundle\Entity\User $fromUser
     * @return Message
     */
    public function setFromUser(\Acme\UserBundle\Entity\User $fromUser)
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    /**
     * Get fromUser
     *
     * @return \Acme\UserBundle\Entity\User 
     */
    public function getFromUser()
    {
        return $this->fromUser;
    }
    
    public function doStuffOnPrePersist()
    {
        $this->createdAt = time();
    }
}
