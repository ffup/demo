<?php
 
namespace Acme\UserBundle\EventListener;
 
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityManager;
 
/**
 * Custom login listener.
 */
class SigninListener
{
	  /** @var \Symfony\Component\Security\Core\SecurityContext */
	  private $securityContext;
	
	  /** @var \Doctrine\ORM\EntityManager */
	  private $em;
	
	  /**
	   * Constructor
	   * 
	   * @param SecurityContext $securityContext
	   * @param Doctrine        $doctrine
	   */
	  public function __construct(SecurityContext $securityContext, EntityManager $em)
	  {
		    $this->securityContext = $securityContext;
		    $this->em              = $em;
	  }
	
	  /**
	   * Do the magic.
	   * 
	   * @param InteractiveLoginEvent $event
	   */
	  public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
	  {
		    if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
			    // user has just logged in
		    }
		
		    if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			    // user has logged in using remember_me cookie
		    }
		
		    // do some other magic here
		    $user = $event->getAuthenticationToken()->getUser();
		    // $user->setCredentialsExpireAt(time() + 300);
		    $user->setLastSigninAt(time());
        $this->em->persist($user);        
		    $this->em->flush();
		    // ...
	  }
}

