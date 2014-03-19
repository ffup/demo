<?php
namespace Acme\BoardBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\BoardBundle\Entity\Module;

class LoadModuleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
    
        $parent1 = new Module();
        $parent1->setParent(null)
            ->setName('module-1')
            ->setDescription('')
            ->setEnableIndexing(true)
            ->setNumThreads(0);
            
        $module1_1 = new Module();
        $module1_1->setName('submodule-1-1')
            ->setDescription('description for submodule-1-1')
            ->setEnableIndexing(false)
            ->setNumThreads(0);
            
        $module1_2 = new Module();
        $module1_2->setName('submodule-1-2')
            ->setDescription('description for submodule-1-2')
            ->setEnableIndexing(false)
            ->setNumThreads(0);
       
        $parent1->addChild($module1_1);
        $parent1->addChild($module1_2);    
        $module1_1->setParent($parent1);
        $module1_2->setParent($parent1);    
        
        
        
        $parent2 = new Module();
        $parent2->setParent(null)
            ->setName('module-2')
            ->setDescription('')
            ->setEnableIndexing(true)
            ->setNumThreads(0);
            
        $module2_1= new Module();
        $module2_1->setName('submodule-2-1')
            ->setDescription('description for submodule-2-1')
            ->setEnableIndexing(false)
            ->setNumThreads(0);
            
        $module2_2 = new Module();
        $module2_2->setName('submodule-2-2')
            ->setDescription('description for submodule-2-2')
            ->setEnableIndexing(false)
            ->setNumThreads(0);
       
        $parent2->addChild($module2_1);
        $parent2->addChild($module2_2);    
        $module2_1->setParent($parent2);
        $module2_2->setParent($parent2); 
                     
        $manager->persist($parent1);                        
        $manager->persist($module1_1);
        $manager->persist($module1_2);        
        
        $manager->persist($parent2);                        
        $manager->persist($module2_1);
        $manager->persist($module2_2);     
              
        $manager->flush();        
        
        $this->addReference('sub_module', $module1_1);     
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}
