<?php

namespace Acme\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;     
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Acme\UserBundle\Entity\UserRepository")
 */
class User implements UserInterface, \Serializable
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
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="Acme\BoardBundle\Entity\ThreadTrack", mappedBy="user")
     */    
    private $threadTracks;

    /**
     * @ORM\OneToMany(targetEntity="Acme\BoardBundle\Entity\CommentTrack", mappedBy="user")
     */    
    private $commentTracks;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     *
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="Acme\BoardBundle\Entity\Thread", mappedBy="user")
     */
    protected $threads;

    /**
     * @ORM\OneToMany(targetEntity="Acme\BoardBundle\Entity\Comment", mappedBy="user")
     */
    protected $comments;

    public function __construct()
    {
        $this->isActive = true;
        $this->threads = new ArrayCollection();
        $this->roles = new ArrayCollection();
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->roles->toArray();
        // return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

    public function isAccountNonExpired()
    {
    	return true;
    }
    
    public function isAccountNonLocked()
    {
    	return true;
    }
    
    public function isCredentialsNonExpired()
    {
    	return true;
    }
    
    public function isEnabled()
    {
    	return $this->isActive;
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    
    public function isEqualTo(UserInterface $user)
    {
    	return $this->id === $user->getId();
    }

    public function isPasswordLegal()
    {
        return $this->username != $this->password;
    }

    /**
     * Add threads
     *
     * @param \Acme\BoardBundle\Entity\Thread $threads
     * @return User
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
     * Add comments
     *
     * @param \Acme\BoardBundle\Entity\Comment $comments
     * @return User
     */
    public function addComment(\Acme\BoardBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

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
     * Add threadTracks
     *
     * @param \Acme\BoardBundle\Entity\ThreadTrack $threadTracks
     * @return User
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
     * Add commentTracks
     *
     * @param \Acme\BoardBundle\Entity\CommentTrack $commentTracks
     * @return User
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
     * Add roles
     *
     * @param \Acme\UserBundle\Entity\Role $roles
     * @return User
     */
    public function addRole(\Acme\UserBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \Acme\UserBundle\Entity\Role $roles
     */
    public function removeRole(\Acme\UserBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }
}
