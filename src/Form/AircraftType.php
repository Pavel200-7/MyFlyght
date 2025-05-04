<?php

namespace App\Form;

use App\Entity\Aircraft;
use App\Entity\AircraftModel;
use App\Entity\Airline;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AircraftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ManufactureDate', null, [
                'widget' => 'single_text',
                'label' => 'Дата изготовления',
            ])
            ->add('registrationNumber')
            ->add('airlineId', EntityType::class, [
                'class' => Airline::class,
                'label' => 'Авиакомпания',
                'choice_label' => 'airlineName',
            ])
            ->add('aircraftModelId', EntityType::class, [
                'class' => AircraftModel::class,
                'label' => 'Модель',
                'choice_label' => 'model',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Aircraft::class,
        ]);
    }
}
