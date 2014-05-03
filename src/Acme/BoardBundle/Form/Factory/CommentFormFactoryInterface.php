<?php

namespace Acme\BoardBundle\Form\Factory;

use Symfony\Component\Form\FormInterface;

/**
 * Comment form creator
 *
 */
interface CommentFormFactoryInterface
{
    /**
     * Creates a comment form
     *
     * @return FormInterface
     */
    public function createForm();
}

