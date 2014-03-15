<?php
namespace Acme\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\UserBundle\Entity\Role;

class LoadRoleData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $role1 = new Role();
        $role1->setName('admin')
            ->setRole('ROLE_ADMIN');
        
        $role2 = new Role();
        $role2->setName('user')
            ->setRole('ROLE_USER');
        
        $manager->persist($role1);
        $manager->persist($role2);                          
        $manager->flush();   
    }
}
