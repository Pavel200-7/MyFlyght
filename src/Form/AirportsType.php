<?php

namespace App\Form;

use App\Entity\Airports;
use App\Entity\Cities;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AirportsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('airportName', null, [
                'label' => 'Наименование аэропорта',
            ])
            ->add('longtitude', NumberType::class, [
                'label' => 'Долгота',
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'Широта',
            ])
            ->add('timezone', null, [
                'label' => 'Временная зона (UTC +)',
            ])
            ->add('city', EntityType::class, [
                'label' => 'Город',
                'class' => Cities::class,
                'choice_label' => 'cityName',
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
