<?php

namespace Acme\BoardBundle\Entity;

class Module
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var boolean
     */
    private $enableIndexing;

    /**
     * @var integer
     */
    private $numThreads;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $threadTracks;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $threads;

    /**
     * @var \Acme\BoardBundle\Entity\Module
     */
    private $parent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Module
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add children
     *
     * @param \Acme\BoardBundle\Entity\Module $children
     * @return Module
     */
    public function addChild(\Acme\BoardBundle\Entity\Module $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Acme\BoardBundle\Entity\Module $children
     */
    public function removeChild(\Acme\BoardBundle\Entity\Module $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Acme\BoardBundle\Entity\Module $parent
     * @return Module
     */
    public function setParent(\Acme\BoardBundle\Entity\Module $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Acme\BoardBundle\Entity\Module 
     */
    public function getParent()
    {
        return $this->parent;
    }

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
     * Add threads
     *
     * @param \Acme\BoardBundle\Entity\Thread $threads
     * @return Module
     */
    public function addThread(\Acme\BoardBundle\Entity\Thread $threads)
    {
        $this->threads[] = $threads;

        return $this;
    }

    /**
     * Remove threads
     *
     * @param \Acme\BoardBundle\Entity\Thread $threads
     */
    public function removeThread(\Acme\BoardBundle\Entity\Thread $threads)
    {
        $this->threads->removeElement($threads);
    }

    /**
     * Get threads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getThreads()
    {
        return $this->threads;
    }


    /**
     * Set numThreads
     *
     * @param integer $numThreads
     * @return Module
     */
    public function setNumThreads($numThreads)
    {
        $this->numThreads = $numThreads;

        return $this;
    }

    /**
     * Get numThreads
     *
     * @return integer 
     */
    public function getNumThreads()
    {
        return $this->numThreads;
    }

    /**
     * Add threadTracks
     *
     * @param \Acme\BoardBundle\Entity\ThreadTrack $threadTracks
     * @return Module
     */
    public function addThreadTrack(\Acme\BoardBundle\Entity\ThreadTrack $threadTracks)
    {
        $this->threadTracks[] = $threadTracks;

        return $this;
    }

    /**
     * Remove threadTracks
     *
     * @param \Acme\BoardBundle\Entity\ThreadTrack $threadTracks
     */
    public function removeThreadTrack(\Acme\BoardBundle\Entity\ThreadTrack $threadTracks)
    {
        $this->threadTracks->removeElement($threadTracks);
    }

    /**
     * Get threadTracks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getThreadTracks()
    {
        return $this->threadTracks;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Module
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set enableIndexing
     *
     * @param boolean $enableIndexing
     * @return Module
     */
    public function setEnableIndexing($enableIndexing)
    {
        $this->enableIndexing = $enableIndexing;

        return $this;
    }

    /**
     * Get enableIndexing
     *
     * @return boolean 
     */
    public function getEnableIndexing()
    {
        return $this->enableIndexing;
    }
}
