<?php

namespace Acme\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\True as Recaptcha;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('plainPassword', 'repeated', array('type' => 'password', 
                'invalid_message' => 'user.password.mismatch'))
            ->add('email')
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
            'data_class' => 'Acme\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_userbundle_user';
    }
}
