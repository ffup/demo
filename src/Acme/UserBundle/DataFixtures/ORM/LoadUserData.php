<?php

namespace Acme\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Acme\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        // User
        $user = new User();
        $user->setUsername('testuser');
        // $user->setSalt(md5(uniqid()));
        $user->addRole($this->getReference('role-user'));
        
        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($user)
        ;
        $user->setPassword($encoder->encodePassword('password', $user->getSalt()));
        $user->setEmail('testuser@email.com');
        
        // Admin
        $admin = new User();
        $admin->setUsername('testadmin');
        $admin->addRole($this->getReference('role-admin'));
        
        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($admin)
        ;
        $admin->setPassword($encoder->encodePassword('password', $admin->getSalt()));
        $admin->setEmail('testadmin@email.com');
        
        // Super admin
        $super = new User();
        $super->setUsername('testsuperadmin');
        $super->addRole($this->getReference('role-super-admin'));
        
        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($super)
        ;
        $super->setPassword($encoder->encodePassword('password', $super->getSalt()));
        $super->setEmail('testsuperadmin@email.com');        
        
        // Persist
        $manager->persist($user);
        $manager->persist($admin);        
        $manager->persist($super);        
        $manager->flush();
    }
    
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}
