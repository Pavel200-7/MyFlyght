<?php

namespace App\Form;

use App\Entity\Airports;
use App\Entity\Cities;
use App\Enum\CompartmentTypeEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MainPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departureAirport', Cities::class, [
                'attr' => ['placeholder' => 'Откуда'],
                'class' => Cities::class,
                'choice_label' => 'CityName',
            ])
            ->add('arrivalAirport', Cities::class, [
                'attr' => ['placeholder' => 'Куда'],
                'class' => Cities::class,
                'choice_label' => 'CityName',
            ])
            ->add('sheduledDeparture', null, [
                'attr' => ['placeholder' => 'Когда'],
                'widget' => 'single_text',
            ])
            ->add('PersonCount', null, [
                'attr' => ['placeholder' => 'Количество человек'],
                'widget' => 'single_text',
            ])
            ->add('ServisClass', EnumType::class, [
                'attr' => ['placeholder' => 'Класс обслуживания'],
                'class' => CompartmentTypeEnum::class,
            ])
        ;
    }

}
