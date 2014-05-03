<?php

namespace Acme\BoardBundle\Form\Factory;

use Symfony\Component\Form\FormInterface;

/**
 * Thread form creator
 */
interface ThreadFormFactoryInterface
{
    /**
     * Creates a thread form
     *
     * @return FormInterface
     */
    public function createForm();
}

