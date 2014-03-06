<?php

namespace Acme\BoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Module
 *
 * @ORM\Table(name="module")
 * @ORM\Entity(repositoryClass="Acme\BoardBundle\Entity\ModuleRepository")
 */
class Module
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\OneToMany(targetEntity="Module", mappedBy="parent")
     **/
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     **/
    private $parent;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Thread", mappedBy="module")
     **/
    protected $threads;
   
    /**
     * @ORM\Column(name="num_threads", type="integer")
     */   
    private $numThreads;
    
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
}
