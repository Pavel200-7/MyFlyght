<?php

namespace App\Form;

use App\Entity\AircraftModel;
use App\Entity\Manufacturers;
use App\Entity\SeatsDiscriptionShablon;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AircraftModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('model', null,[
                'label' => 'Наименование модели',
            ])
            ->add('seatsDiscriptionId', EntityType::class, [
                'class' => SeatsDiscriptionShablon::class,
                'choice_label' => 'SeatsDiscriptionShablonName',
                'label' => 'Шаблон посадочных мест'
            ])
            ->add('manufacturerId', EntityType::class, [
                'class' => Manufacturers::class,
                'choice_label' => 'manufacturerName',
                'label' => 'Изготовитель'
            ])
            ->add('averageSpeed', null,[
                'label' => 'Средняя скорость (км/ч)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AircraftModel::class,
        ]);
    }
}
