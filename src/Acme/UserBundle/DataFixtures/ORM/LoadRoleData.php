<?php
namespace Acme\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\UserBundle\Entity\Role;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $roleAdmin = new Role();
        $roleAdmin->setName('admin')
            ->setRole('ROLE_ADMIN');
        
        $roleUser = new Role();
        $roleUser->setName('user')
            ->setRole('ROLE_USER');
        
        $roleSuperAdmin = new Role();
        $roleSuperAdmin->setName('super_admin')
            ->setRole('ROLE_SUPER_ADMIN');
        
        $manager->persist($roleAdmin);
        $manager->persist($roleUser);
        $manager->persist($roleSuperAdmin);
        $manager->flush();
        
        $this->addReference('role-user', $roleUser);
        $this->addReference('role-admin', $roleAdmin);
        $this->addReference('role-super-admin', $roleSuperAdmin);                
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}
