<?php

namespace Acme\BoardBundle\Entity;

use Acme\BoardBundle\Events;
use Acme\BoardBundle\Event\ThreadEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Abstract Thread Manager implementation which can be used as base class for your
 * concrete manager.
 *
 */
abstract class ThreadManager implements ThreadManagerInterface
{
    protected $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param  string          $id
     * @return ThreadInterface
     */
    public function findThreadById($id)
    {
        return $this->findThreadBy(array('id' => $id));
    }

    /**
     * Creates an empty comment thread instance
     *
     * @return Thread
     */
    public function createThread($id = null)
    {
        $class = $this->getClass();
        $thread = new $class;

        if (null !== $id) {
            $thread->setId($id);
        }

        $event = new ThreadEvent($thread);
        $this->dispatcher->dispatch(Events::THREAD_CREATE, $event);

        return $thread;
    }

    /**
     * Persists a thread.
     *
     * @param ThreadInterface $thread
     */
    public function saveThread(ThreadInterface $thread)
    {
        $event = new ThreadEvent($thread);
        $this->dispatcher->dispatch(Events::THREAD_PRE_PERSIST, $event);

        $this->doSaveThread($thread);

        $event = new ThreadEvent($thread);
        $this->dispatcher->dispatch(Events::THREAD_POST_PERSIST, $event);
    }

    /**
     * Performs the persistence of the Thread.
     *
     * @abstract
     * @param ThreadInterface $thread
     */
    abstract protected function doSaveThread(ThreadInterface $thread);
}

