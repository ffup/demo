<?php

namespace Acme\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('current_password', 'password', array(
            'label' => 'form.current_password',
            'mapped' => false,
            'constraints' => new UserPassword(),
        ));
        
        $builder->add('plainPassword', 'repeated', array('type' => 'password', 
            'invalid_message' => 'user.password.mismatch', ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\UserBundle\Entity\User',
            // 'intention'  => 'change_password',
        ));
    }

    public function getName()
    {
        return 'change_password';
    }
}
