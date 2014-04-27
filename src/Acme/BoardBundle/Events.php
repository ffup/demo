<?php

namespace Acme\BoardBundle;

final class Events
{
    /**
     * The PRE_PERSIST event occurs prior to the persistence backend
     * persisting the Comment.
     *
     * This event allows you to modify the data in the Comment prior
     * to persisting occuring. The listener receives a
     * Acme\BoardBundle\Event\CommentPersistEvent instance.
     *
     * Persisting of the comment can be aborted by calling
     * $event->abortPersist()
     *
     * @var string
     */
    const COMMENT_PRE_PERSIST = 'acme.comment.pre_persist';

    /**
     * The POST_PERSIST event occurs after the persistence backend
     * persisted the Comment.
     *
     * This event allows you to notify users or perform other actions
     * that might require the Comment to be persisted before performing
     * those actions. The listener receives a
     * Acme\BoardBundle\Event\CommentEvent instance.
     *
     * @var string
     */
    const COMMENT_POST_PERSIST = 'acme.comment.post_persist';

    /**
     * The CREATE event occurs when the manager is asked to create
     * a new instance of a Comment.
     *
     * The listener receives a Acme\BoardBundle\Event\CommentEvent
     * instance.
     *
     * @var string
     */
    const COMMENT_CREATE = 'acme.comment.create';

    /**
     * The PRE_PERSIST event occurs prior to the persistence backend
     * persisting the Thread.
     *
     * This event allows you to modify the data in the Thread prior
     * to persisting occuring. The listener receives a
     * Acme\BoardBundle\Event\ThreadEvent instance.
     *
     * @var string
     */
    const THREAD_PRE_PERSIST = 'acme.thread.pre_persist';

    /**
     * The POST_PERSIST event occurs after the persistence backend
     * persisted the Thread.
     *
     * This event allows you to notify users or perform other actions
     * that might require the Thread to be persisted before performing
     * those actions. The listener receives a
     * Acme\BoardBundle\Event\ThreadEvent instance.
     *
     * @var string
     */
    const THREAD_POST_PERSIST = 'acme.thread.post_persist';

    /**
     * The CREATE event occurs when the manager is asked to create
     * a new instance of a Thread.
     *
     * The listener receives a Acme\BoardBundle\Event\ThreadEvent
     * instance.
     *
     * @var string
     */
    const THREAD_CREATE = 'acme.thread.create';

    /**
     * The PRE_PERSIST event occurs prior to the persistence backend
     * persisting the Vote.
     *
     * This event allows you to modify the data in the Vote prior
     * to persisting occuring. The listener receives a
     * Acme\BoardBundle\Event\VoteEvent instance.
     *
     * @var string
     */
    const VOTE_PRE_PERSIST = 'acme.vote.pre_persist';

    /**
     * The POST_PERSIST event occurs after the persistence backend
     * persisted the Vote.
     *
     * This event allows you to notify users or perform other actions
     * that might require the Vote to be persisted before performing
     * those actions. The listener receives a
     * Acme\BoardBundle\Event\VoteEvent instance.
     *
     * @var string
     */
    const VOTE_POST_PERSIST = 'acme.vote.post_persist';

    /**
     * The CREATE event occurs when the manager is asked to create
     * a new instance of a Vote.
     *
     * The listener receives a Acme\BoardBundle\Event\VoteEvent
     * instance.
     *
     * @var string
     */
    const VOTE_CREATE = 'acme.vote.create';
}
