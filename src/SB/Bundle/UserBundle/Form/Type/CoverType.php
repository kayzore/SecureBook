<?php

namespace SB\Bundle\UserBundle\Form\Type;

use SB\Bundle\UserBundle\Entity\Cover;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, array(
                "label" => false,
                "required" => true,
                "attr" => array(
                    "accept" => "image/*",
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Cover::class,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'user_cover';
    }
}
