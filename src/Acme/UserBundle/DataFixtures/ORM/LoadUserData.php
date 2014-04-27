<?php

namespace Acme\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Acme\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements 
    FixtureInterface, 
    ContainerAwareInterface, 
    OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('user_manager');
        // User
        $user = new User();
        $user->setUsername('testuser')
            ->setEmail('testuser@email.com')
            ->setPlainPassword('password');
        // $user->setSalt(md5(uniqid()));
        $user->addRole($this->getReference('role-user'));
          
        $userManager->updateUser($user);
        
        // Admin
        $admin = new User();
        $admin->setUsername('testadmin')
            ->setEmail('testadmin@email.com')
            ->setPlainPassword('password');
            
        $admin->addRole($this->getReference('role-admin'));
        
        $userManager->updateUser($admin);
             
        // Super admin
        $super = new User();
        $super->setUsername('testsuperadmin')
            ->setEmail('testsuperadmin@email.com')
            ->setPlainPassword('password');
            
        $super->addRole($this->getReference('role-super-admin'));
        
        $userManager->updateUser($super);            
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}
