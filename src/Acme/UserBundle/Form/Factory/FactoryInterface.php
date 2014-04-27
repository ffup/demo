<?php

namespace Acme\UserBundle\Form\Factory;

interface FactoryInterface
{
    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createForm();
}
