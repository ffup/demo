<?php

namespace Acme\UserBundle\Doctrine;

use Doctrine\ORM\EntityManager;
use Acme\UserBundle\Entity\ThreadInterface;
use Acme\UserBundle\Entity\ThreadManager as BaseThreadManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Default ORM ThreadManager.
 *
 */
class ThreadManager extends BaseThreadManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     * @param \Doctrine\ORM\EntityManager                                 $em
     * @param string                                                      $class
     */
    public function __construct(EventDispatcherInterface $dispatcher, EntityManager $em, $class)
    {
        parent::__construct($dispatcher);

        $this->em = $em;
        $this->repository = $em->getRepository($class);

        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->name;
    }

    /**
     * Finds one comment thread by the given criteria
     *
     * @param  array           $criteria
     * @return ThreadInterface
     */
    public function findThreadBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findThreadsBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * Finds all threads.
     *
     * @return array of ThreadInterface
     */
    public function findAllThreads()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function isNewThread(ThreadInterface $thread)
    {
        return !$this->em->getUnitOfWork()->isInIdentityMap($thread);
    }

    /**
     * Saves a thread
     *
     * @param ThreadInterface $thread
     */
    protected function doSaveThread(ThreadInterface $thread)
    {
        $this->em->persist($thread);
        $this->em->flush();
    }

    /**
     * Returns the fully qualified comment thread class name
     *
     * @return string
     **/
    public function getClass()
    {
        return $this->class;
    }
}

