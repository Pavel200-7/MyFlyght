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
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FlightsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $airline = $options['airline'] ?? null;

        $builder
            ->add('flightNumber', null, [
                'label' => 'Номер авиаперелета',
            ])
            ->add('sheduledDeparture', null, [
                'widget' => 'single_text',
                'label' => 'Время отправки',
            ])
            ->add('sheduledArrival', null, [
                'widget' => 'single_text',
                'label' => 'Время прибытия',
            ])
            ->add('departureAirport', EntityType::class, [
                'class' => Airports::class,
                'choice_label' => function (Airports $airport) {
                    return $airport->getAirportName() . ' (' . $airport->getCity()->getCityName() . ')';
                },
                'label' => 'Аэропорт отправки',
                'empty_data' => 'Аэропорт отправки',

            ])
            ->add('arrivalAirport', EntityType::class, [
                'class' => Airports::class,
                'choice_label' => function (Airports $airport) {
                    return $airport->getAirportName() . ' (' . $airport->getCity()->getCityName() . ')';
                },
                'label' => 'Аэропорт прибытия',
                'empty_data' => 'Аэропорт прибытия',
            ])
            ->add('aircraftId', EntityType::class, [
                'class' => Aircraft::class,
                'choice_label' => function (Aircraft $aircraft) {
                    return $aircraft->getAircraftModelId()->getModel() . ' (' . $aircraft->getRegistrationNumber() . ')';
                },
                'label' => 'Транспорт',
                'query_builder' => function ($repository) use ($airline) {
                    // Проверяем, передана ли авиакомпания
                    if ($airline) {
                        return $repository->createQueryBuilder('a')
                            ->where('a.airlineId = :airline')
                            ->setParameter('airline', $airline);
                    }
                    // Если авиакомпания не указана, возвращат все
                    return $repository->createQueryBuilder('a');
                }
            ])
            ->add('handLuggagePoliticyID', EntityType::class, [
                'class' => HundLuggagePoliticy::class,
                'choice_label' => 'hundLuggagePoliticyname',
                'label' => 'Ручной клади',
            ])
            ->add('baggagePoliticyID', EntityType::class, [
                'class' => BaggagePoliticy::class,
                'choice_label' => 'baggagePoliticyname',
                'label' => 'Политика багажа',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Flights::class,
            'airline' => null,
        ]);
    }
}
