<?php

namespace SB\UserBundle\Form\Type;

use SB\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array(
                'label' => 'Email',
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('username', 'text', array(
                'label' => 'Pseudo',
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options'  => array(
                    'label' => 'Mot de passe',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ),
                'second_options' => array(
                    'label' => 'Confirmation mot de passe',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ),
            ))
            ->add('save', 'submit', array(
                'attr' => array(
                    'class' => 'btn btn-primary'
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

    public function getName()
    {
        return 'user';
    }
}