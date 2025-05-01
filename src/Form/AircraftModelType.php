<?php

namespace App\Form;

use App\Entity\AircraftModel;
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
            ->add('model')
            ->add('MaxSits')
            ->add('MaxWeight')
            ->add('seatsDiscriptionId', EntityType::class, [
                'class' => SeatsDiscriptionShablon::class,
                'choice_label' => 'id',
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
