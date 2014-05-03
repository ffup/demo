<?php

namespace Acme\BoardBundle\Form\Factory;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * ThreadForm factory class.
 */
class ThreadFormFactory implements ThreadFormFactoryInterface
{
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $name;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param string               $type
     * @param string               $name
     */
    public function __construct(FormFactoryInterface $formFactory, $type, $name)
    {
        $this->formFactory = $formFactory;
        $this->type        = $type;
        $this->name        = $name;
    }

    /**
     * Creates a new form.
     *
     * @return FormInterface
     */
    public function createForm()
    {
        $builder = $this->formFactory->createNamedBuilder(
            $this->name, 
            $this->type, 
            null, 
            array('validation_groups' => array())
        );

        return $builder->getForm();
    }
}

