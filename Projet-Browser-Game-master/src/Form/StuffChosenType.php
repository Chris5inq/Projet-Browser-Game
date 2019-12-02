<?php

namespace App\Form;

use App\Entity\Stuff;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Session\SessionInterface;




class StuffChosenType extends AbstractType
{
    private $session;
    private $em;

    public function __construct(SessionInterface $session, EntityManagerInterface $em)
    {
        $this->session = $session;
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        
        
        $stuff_session = $this->session->get('stuff');

        //dd($stuff_session);

        foreach($stuff_session as $slot_name => $_stuff)
        {
            foreach($_stuff as $stuff) $this->em->persist($stuff);

            $builder->add("$slot_name", EntityType::class, [
                'class' => Stuff::class,
                'label' => $slot_name,
                'choice_label' => function ($stuff) {
                    return $stuff->getName();
                },
                'choices' => $_stuff,
                'expanded' => true
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
