<?php

namespace App\Form;

use App\Entity\Cities;
use App\Enum\CompartmentTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class MainPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departureCity', EntityType::class, [
                'placeholder' => 'Откуда',
                'class' => Cities::class,
                'choice_label' => 'CityName',
            ])
            ->add('arrivalCity', EntityType::class, [
                'placeholder' => 'Куда',
                'class' => Cities::class,
                'choice_label' => 'CityName',
            ])
            ->add('sheduledDeparture', DateType::class, [
                'placeholder' => 'Когда',
                'attr' => [
                    'placeholder' => 'Когда', // ваш текст для placeholder
                ],
                'widget' => 'single_text',

            ])
            ->add('PersonCount', ChoiceType::class, [
                'placeholder' => 'Количество человек',
                'choices'  => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
//                'choice_label' => 'displayName',
                'data' => '1',
//                'widget' => 'single_text',
            ])
            ->add('ServisClass', EnumType::class, [
                'placeholder' => 'Класс обслуживания',
                'class' => CompartmentTypeEnum::class,
                'choice_label' => 'value',
                'data' => CompartmentTypeEnum::Economy,

            ])
        ;
    }


}
