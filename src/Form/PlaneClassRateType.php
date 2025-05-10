<?php

namespace App\Form;

use App\Entity\Airline;
use App\Entity\PlaneClassRate;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaneClassRateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('classType', null, [
                'label' => ' Класс обслуживания',
                'attr' => ['readonly' => true],
                ])
            ->add('costPerKM', null, [
                'label' => 'стоимость за километр',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlaneClassRate::class,
        ]);
    }
}
