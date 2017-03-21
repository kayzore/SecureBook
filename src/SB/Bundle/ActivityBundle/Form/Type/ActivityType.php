<?php

namespace SB\Bundle\ActivityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', TextareaType::class, array(
                'label'         => false,
                'required'      => false,
                'attr' => array(
                    'class'         => 'form-control autogrow',
                    'placeholder'   => 'Publiez quelque chose !',
                    'id'            => 'textareaAddActu',
                    'name'          => 'activity_message'
                )
            ))
            ->add('image', ImageType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SB\Bundle\ActivityBundle\Entity\Activity'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'sb_activity';
    }
}
