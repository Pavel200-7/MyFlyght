<?php

namespace App\Form;

use App\Entity\SeatsDiscriptionShablon;
use App\Entity\SeatShablon;
use App\Enum\CompartmentTypeEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeatShablonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('compartmentNumber')
//            ->add('compartmentType')
            ->add('compartmentType', EnumType::class, [
                'class' => CompartmentTypeEnum::class,
//                'choice_value' => 'value',
            ])
            ->add('zoneNumber')
            ->add('sectorNumber')
            ->add('row')
            ->add('numberInRow')
            ->add('SeatShablon', EntityType::class, [
                'class' => SeatsDiscriptionShablon::class,
                'choice_label' => 'SeatsDiscriptionShablonName',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeatShablon::class,
        ]);
    }
}
