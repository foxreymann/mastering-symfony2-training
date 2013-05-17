<?php

namespace Sensio\Bundle\HangmanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email','email')
            ->add('rawpassword','repeated', array(
                'type' => 'password',
                'first_options' => array('label' => "Password"),
                'second_options' => array('label' => "Confirm") 
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sensio\Bundle\HangmanBundle\Entity\Player'
        ));
    }

    public function getName()
    {
        return 'player';
    }
}
