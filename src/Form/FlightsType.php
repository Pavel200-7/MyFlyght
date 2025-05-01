<?php

namespace App\Form;

use App\Entity\Aircraft;
use App\Entity\Airline;
use App\Entity\Airports;
use App\Entity\BaggagePoliticy;
use App\Entity\Flights;
use App\Entity\HundLuggagePoliticy;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sheduledDeparture', null, [
                'widget' => 'single_text',
            ])
            ->add('sheduledArrival', null, [
                'widget' => 'single_text',
            ])
            ->add('finished')
            ->add('actualDeparture', null, [
                'widget' => 'single_text',
            ])
            ->add('actualArrival', null, [
                'widget' => 'single_text',
            ])
            ->add('flightNumber')
            ->add('departureAirport', EntityType::class, [
                'class' => Airports::class,
                'choice_label' => 'id',
            ])
            ->add('arrivalAirport', EntityType::class, [
                'class' => Airports::class,
                'choice_label' => 'id',
            ])
            ->add('aircraftId', EntityType::class, [
                'class' => Aircraft::class,
                'choice_label' => 'id',
            ])
            ->add('airliniID', EntityType::class, [
                'class' => Airline::class,
                'choice_label' => 'id',
            ])
            ->add('handLuggagePoliticyID', EntityType::class, [
                'class' => HundLuggagePoliticy::class,
                'choice_label' => 'id',
            ])
            ->add('baggagePoliticyID', EntityType::class, [
                'class' => BaggagePoliticy::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Flights::class,
        ]);
    }
}
