<?php

namespace App\Form;

use App\Entity\Boss;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BossType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('health')
            ->add('armour')
            ->add('resist_fire')
            ->add('resist_ice')
            ->add('power')
            ->add('power_ice')
            ->add('power_fire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Boss::class,
        ]);
    }
}
