<?php

namespace Acme\BoardBundle\Event;

use Acme\BoardBundle\Entity\ThreadInterface;
use Symfony\Component\EventDispatcher\Event;

class ThreadEvent extends Event
{
    private $thread;

    /**
     * Constructs an event.
     *
     * @param \Acme\BoardBundle\Entity\ThreadInterface $thread
     */
    public function __construct(ThreadInterface $thread)
    {
        $this->thread = $thread;
    }

    /**
     * Returns the thread for this event.
     *
     * @return \Acme\BoardBundle\Entity\ThreadInterface
     */
    public function getThread()
    {
        return $this->thread;
    }
}

