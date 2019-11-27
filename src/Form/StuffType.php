<?php

namespace App\Form;

use App\Entity\Stuff;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StuffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('m_health')
            ->add('m_armour')
            ->add('m_resist_fire')
            ->add('m_resist_ice')
            ->add('m_power')
            ->add('m_power_ice')
            ->add('m_power_fire')
            ->add('fights')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stuff::class,
        ]);
    }
}
