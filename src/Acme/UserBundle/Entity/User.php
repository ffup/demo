<?php

namespace Acme\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;     
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserRepository")
 */
class User implements AdvancedUserInterface, \Serializable, EquatableInterface
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
    private $isActive = true;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     *
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="Acme\BoardBundle\Entity\Thread", mappedBy="user")
     */
    private $threads;

    /**
     * @ORM\OneToMany(targetEntity="Acme\BoardBundle\Entity\Comment", mappedBy="user", fetch="EXTRA_LAZY")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="fromUser", fetch="EXTRA_LAZY")
     */  
    private $sendMessages;
    
    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="toUser", fetch="EXTRA_LAZY")
     */      
    private $receiveMessages;

    /** 
     * @ORM\Column(name="unread_msg", type="smallint", options={"unsigned"=true})    
     */
    private $unreadMsg = 0;
    
    /**
     * @ORM\Column(name="credentials_expired", type="boolean")
     */
    private $credentialsExpired = false;

    /**
     * @ORM\Column(name="credentials_expire_at", type="integer", options={"unsigned"=true}, nullable=true)
     */
    private $credentialsExpireAt;
    
    /**
     * @ORM\Column(name="is_locked", type="boolean")
     */    
    private $isLocked = false;
    
    /**
     * @ORM\Column(name="is_expired", type="boolean")
     */    
    private $isExpired = false;
    
    /**
     * @ORM\Column(name="last_signin_at", type="integer", options={"unsigned"=true}, nullable=true)
     */    
    private $lastSigninAt;
    
    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     */
    protected $plainPassword;

    public function __construct()
    {
        $this->threads = new ArrayCollection();
        $this->roles = new ArrayCollection();
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }
    
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
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
        $this->plainPassword = null;
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
            $this->isActive,
            $this->isLocked,
            $this->isExpired,            
            $this->credentialsExpired,         
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
            $this->isActive,
            $this->isLocked,
            $this->isExpired,                               
            $this->credentialsExpired,                    
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

    public function isAccountNonExpired()
    {
    	  return !$this->isExpired;
    }
    
    public function isAccountNonLocked()
    {
    	  return !$this->isLocked;
    }
    
    public function isCredentialsNonExpired()
    {
        if (true === $this->credentialsExpired) {
            return false;
        }
    
        if (null !== $this->credentialsExpireAt && 
            $this->credentialsExpireAt < time()) {
            return false;
        }
        
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
    	  if ($this->id !== $user->getId()) {
            return false;
    	  }
    	  
        if ($this->password !== $user->getPassword()) {
            throw new BadCredentialsException('Password has been changed!');
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
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
    public function addThread(\Acme\BoardBundle\Entity\Thread $thread)
    {
        $this->threads[] = $thread;
        $thread->setUser($this);
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
    public function addComment(\Acme\BoardBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;
        $comment->setUser($this);
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

    /**
     * Add sendMessages
     *
     * @param \Acme\UserBundle\Entity\Message $sendMessages
     * @return User
     */
    public function addSendMessage(\Acme\UserBundle\Entity\Message $sendMessages)
    {
        $this->sendMessages[] = $sendMessages;

        return $this;
    }

    /**
     * Remove sendMessages
     *
     * @param \Acme\UserBundle\Entity\Message $sendMessages
     */
    public function removeSendMessage(\Acme\UserBundle\Entity\Message $sendMessages)
    {
        $this->sendMessages->removeElement($sendMessages);
    }

    /**
     * Get sendMessages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSendMessages()
    {
        return $this->sendMessages;
    }

    /**
     * Add receiveMessages
     *
     * @param \Acme\UserBundle\Entity\Message $receiveMessages
     * @return User
     */
    public function addReceiveMessage(\Acme\UserBundle\Entity\Message $receiveMessages)
    {
        $this->receiveMessages[] = $receiveMessages;

        return $this;
    }

    /**
     * Remove receiveMessages
     *
     * @param \Acme\UserBundle\Entity\Message $receiveMessages
     */
    public function removeReceiveMessage(\Acme\UserBundle\Entity\Message $receiveMessages)
    {
        $this->receiveMessages->removeElement($receiveMessages);
    }

    /**
     * Get receiveMessages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReceiveMessages()
    {
        return $this->receiveMessages;
    }


    /**
     * Set unreadMsg
     *
     * @param integer $unreadMsg
     * @return User
     */
    public function setUnreadMsg($unreadMsg)
    {
        $this->unreadMsg = $unreadMsg;

        return $this;
    }

    /**
     * Get unreadMsg
     *
     * @return integer 
     */
    public function getUnreadMsg()
    {
        return $this->unreadMsg;
    }

    /**
     * Set credentialsExpired
     *
     * @param boolean $credentialsExpired
     * @return User
     */
    public function setCredentialsExpired($credentialsExpired)
    {
        $this->credentialsExpired = $credentialsExpired;

        return $this;
    }

    /**
     * Get credentialsExpired
     *
     * @return boolean 
     */
    public function getCredentialsExpired()
    {
        return $this->credentialsExpired;
    }

    /**
     * Set credentialsExpireAt
     *
     * @param integer $credentialsExpireAt
     * @return User
     */
    public function setCredentialsExpireAt($credentialsExpireAt)
    {
        $this->credentialsExpireAt = $credentialsExpireAt;

        return $this;
    }

    /**
     * Get credentialsExpireAt
     *
     * @return integer 
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }

    /**
     * Set isLocked
     *
     * @param boolean $isLocked
     * @return User
     */
    public function setIsLocked($isLocked)
    {
        $this->isLocked = $isLocked;

        return $this;
    }

    /**
     * Get isLocked
     *
     * @return boolean 
     */
    public function getIsLocked()
    {
        return $this->isLocked;
    }

    /**
     * Set isExpired
     *
     * @param boolean $isExpired
     * @return User
     */
    public function setIsExpired($isExpired)
    {
        $this->isExpired = $isExpired;

        return $this;
    }

    /**
     * Get isExpired
     *
     * @return boolean 
     */
    public function getIsExpired()
    {
        return $this->isExpired;
    }

    /**
     * Set lastSigninAt
     *
     * @param integer $lastSigninAt
     * @return User
     */
    public function setLastSigninAt($lastSigninAt)
    {
        $this->lastSigninAt = $lastSigninAt;

        return $this;
    }

    /**
     * Get lastSigninAt
     *
     * @return integer 
     */
    public function getLastSigninAt()
    {
        return $this->lastSigninAt;
    }
}
