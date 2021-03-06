<?php

namespace Acme\BoardBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ModuleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ModuleRepository extends EntityRepository
{
    public function findAllModules()
    {   
        $dql = 'SELECT m, c FROM AcmeBoardBundle:Module m LEFT JOIN m.children c
            WHERE m.parent IS NULL';
        $query = $this->_em->createQuery($dql);

        return $query->getResult();
    }
}
