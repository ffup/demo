<?php

namespace Acme\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\True as Recaptcha;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class RegistrationType extends AbstractType
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
            ->add('email');
            
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
    }
    
    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        
        $this->buildRecaptchaForm($form);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\UserBundle\Entity\User',
            'intention'  => 'registration',
            'error_mapping' => array(
                'passwordLegal' => 'plainPassword',
            ),            
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'registration';
    }
    
    /**
     * Builds the embedded form representing the Recaptcha.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    protected function buildRecaptchaForm(\Symfony\Component\Form\Form $form)
    {
        $form->add('recaptcha', 'ewz_recaptcha', 
            array(
                'mapped' => false,
                'constraints' => array(new Recaptcha()),
            )
        );
        // TODO           
    }
}
