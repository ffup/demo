<?php

namespace Acme\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Acme\UserBundle\Form\DataTransformer\UserToUsernameTransformer;

class MessageType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // this assumes that the entity manager was passed in as an option
        $entityManager = $options['em'];
        $transformer = new UserToUsernameTransformer($entityManager);
    
        // add a normal text field, but add your transformer to it
        $builder->add(
            $builder->create('toUser', 'text')
                ->addModelTransformer($transformer)
        );
    
        $builder
        /*
            ->add('toUser', 'entity', array(
                'class' => 'AcmeUserBundle:User',
                'property' => 'username',
                ))
        */
            ->add('title')
            ->add('content', 'textarea')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\UserBundle\Entity\Message',
        ))
        ->setRequired(array(
            'em',
        ))
        ->setAllowedTypes(array(
            'em' => 'Doctrine\Common\Persistence\ObjectManager',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_userbundle_message';
    }
}
