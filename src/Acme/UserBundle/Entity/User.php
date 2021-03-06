<?php

namespace Acme\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

class User implements UserInterface
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $usernameCanonical;

    /**
     * @var string
     */
    private $emailCanonical;

    /**
     * @var string
     */
    private $email;

    /**
     * @var boolean
     */
    private $isActive = true;

    /**
     * @var integer
     */
    private $unreadMsg = 0;

    /**
     * @var boolean
     */
    private $credentialsExpired = false;

    /**
     * @var integer
     */
    private $credentialsExpireAt;

    /**
     * @var boolean
     */
    private $isLocked = false;

    /**
     * @var boolean
     */
    private $isExpired = false;

    /**
     * @var integer
     */
    private $lastSigninAt;

    /**
     * @var string
     */
    private $confirmationToken;

    /**
     * @var integer
     */
    private $passwordRequestedAt;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sendMessages;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $receiveMessages;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $comments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $threads;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $threadTracks;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $commentTracks;

    /**
     * @var array
     */
    private $roles;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     */
    private $plainPassword;

    public function __construct()
    {
        $this->threads = new ArrayCollection();
        $this->roles = array();
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
    
    public function isEqualTo(BaseUserInterface $user)
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
        return $this->username != $this->plainPassword;
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

    /**
     * Set confirmationToken
     *
     * @param string $confirmationToken
     * @return User
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * Get confirmationToken
     *
     * @return string 
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Set passwordRequestedAt
     *
     * @param integer $passwordRequestedAt
     * @return User
     */
    public function setPasswordRequestedAt($passwordRequestedAt = null)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }

    /**
     * Get passwordRequestedAt
     *
     * @return integer 
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }
    
    public function isPasswordRequestNonExpired($ttl)
    {
        return is_int($this->getPasswordRequestedAt()) &&
            $this->getPasswordRequestedAt() + $ttl > time();
    }

    /**
     * Set usernameCanonical
     *
     * @param string $usernameCanonical
     * @return User
     */
    public function setUsernameCanonical($usernameCanonical)
    {
        $this->usernameCanonical = $usernameCanonical;

        return $this;
    }

    /**
     * Get usernameCanonical
     *
     * @return string 
     */
    public function getUsernameCanonical()
    {
        return $this->usernameCanonical;
    }

    /**
     * Set emailCanonical
     *
     * @param string $emailCanonical
     * @return User
     */
    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;

        return $this;
    }

    /**
     * Get emailCanonical
     *
     * @return string 
     */
    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }
    
    public function isSuperAdmin()
    {
        return $this->hasRole(static::ROLE_SUPER_ADMIN);
    }
    
    public function setSuperAdmin($boolean)
    {
        if (true === $boolean) {
            $this->addRole(static::ROLE_SUPER_ADMIN);
        } else {
            $this->removeRole(static::ROLE_SUPER_ADMIN);
        }

        return $this;
    }
    
    public function removeRole($role)
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }
    
    public function setRoles(array $roles)
    {
        $this->roles = array();

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }
    
    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === static::ROLE_DEFAULT) {
            return $this;
        }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }
    
    /**
     * Never use this to check if this user has access to anything!
     *
     * Use the SecurityContext, or an implementation of AccessDecisionManager
     * instead, e.g.
     *
     *         $securityContext->isGranted('ROLE_USER');
     *
     * @param string $role
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }
    
    /**
     * Returns the user roles
     *
     * @return array The roles
     */
    public function getRoles()
    {
        $roles = $this->roles;

        /*
        foreach ($this->getGroups() as $group) {
            $roles = array_merge($roles, $group->getRoles());
        }
        */
        
        // we need to make sure to have at least one role
        $roles[] = static::ROLE_DEFAULT;

        return array_unique($roles);
    }
}
