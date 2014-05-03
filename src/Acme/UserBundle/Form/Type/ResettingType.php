<?php

namespace Acme\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResettingType extends AbstractType
{
    private $class;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'first_options' => array('label' => 'new_password'),
            'second_options' => array('label' => 'new_password_confirmation'),
            'invalid_message' => 'password.mismatch',
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\UserBundle\Entity\User',
            'intention'  => 'resetting',
        ));
    }

    public function getName()
    {
        return 'resetting';
    }
}

