<?php

namespace Acme\BoardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Acme\BoardBundle\Entity\Thread;

class ThreadType extends AbstractType
{
    private $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content', 'textarea')
            ->add('status', 'choice', array(
                'empty_value' => false,
                'choices' => array(
                    Thread::ITEM_UNLOCKED => 'Default', 
                    Thread::ITEM_LOCKED => 'Locked'),
                'required' => false,
            ));
            
        // grab the user, do a quick sanity check that one exists
        // $user = $this->securityContext->getToken()->getUser();
            
        $securityContext = $this->securityContext;
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
    }
    
    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        
        if ($this->securityContext->isGranted('ROLE_ADMIN')) {
            $form->add('type', 'choice', array(
                'empty_value' => false,
                'choices' => array(
                    Thread::POST_NORMAL => 'NORMAL', 
                    Thread::POST_STICKY => 'STICKY',
                    Thread::POST_ANNOUNCE => 'ANNOUNCE'),
                'required' => false,
            ));
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\BoardBundle\Entity\Thread'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_boardbundle_thread';
    }
}
