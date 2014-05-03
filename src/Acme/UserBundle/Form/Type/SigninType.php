<?php

namespace Acme\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\True as Recaptcha;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class SigninType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', 'password')
            ->add('recaptcha', 'ewz_recaptcha', 
                array(
                    'mapped' => false,
                    'constraints' => array(new Recaptcha()),
                )
            );
    }
       
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\UserBundle\Entity\User',
            'validation_groups' => array('Signin'),
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'signin';
    }
}
