<?php

namespace App\Form;

use Faker;
use App\Entity\Stuff;
use App\Entity\Slot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StuffNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $faker = Faker\Factory::create('fr_FR');
        
        $builder
        ->add('name', TextType::class,[
            "data" => $faker->lastName()     
        ])
        ->add('m_health', IntegerType::class,[
            "data" => 1000
        ])
        ->add('m_armour', IntegerType::class,[
            "data" => rand(-5, 5)
        ])
        ->add('m_resist_fire', IntegerType::class,[
            "data" => rand(-5, 5)
        ])
        ->add('m_resist_ice', IntegerType::class,[
            "data" => rand(-5, 5)
        ])
        ->add('m_power', IntegerType::class,[
            "data" => rand(-5, 5)
        ])
        ->add('m_power_ice', IntegerType::class,[
            "data" => rand(-5, 5)
        ])
        ->add('m_power_fire', IntegerType::class,[
            "data" => rand(-5, 5)
        ])
            ->add('slot', EntityType::class,[
                'class' => Slot::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stuff::class,
        ]);
    }
}
