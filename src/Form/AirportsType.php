<?php

namespace App\Form;

use App\Entity\Airports;
use App\Entity\Cities;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AirportsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('AirportName')
            ->add('longtitude')
            ->add('latitude')
            ->add('timezone')
            ->add('City', EntityType::class, [
                'class' => Cities::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Airports::class,
        ]);
    }
}
