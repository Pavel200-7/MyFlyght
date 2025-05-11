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
            ])
            ->add('arrivalAirport', EntityType::class, [
                'class' => Airports::class,
                'choice_label' => function (Airports $airport) {
                    return $airport->getAirportName() . ' (' . $airport->getCity()->getCityName() . ')';
                },
                'label' => 'Аэропорт прибытия',
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
            ->add('airliniID', EntityType::class, [
                'class' => Airline::class,
                'choice_label' => 'airlineName',
                'attr' => ['readonly' => true],
                'label' => 'Авиакомпания',
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
            ->add('flightNumber', null, [
                'label' => 'Номер авиаперелета',
            ])
            ->add('finished', null, [
                'label' => 'завершен',
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if (!isset($data['departureAirport']) || !isset($data['arrivalAirport'])) {
                return;
            }

            if ($data['departureAirport'] == $data['arrivalAirport']) {
                // Можно выбросить ошибку или сбросить одно из значений
                $form->get('arrivalAirport')->addError(new FormError('Аэропорты не могут быть одинаковыми.'));
            }
        });

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Flights::class,
            'airline' => null,
        ]);
    }
}
