<?php

namespace App\Form;

use App\Entity\Airline;
use App\Entity\BaggagePoliticy;
use App\Entity\BaggagePoliticyRate;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaggagePoliticyRateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('costPerKM', null, [
                'label' => 'стоимость за километр',
                ])
            ->add('baggagePoliticyID', EntityType::class, [
                'class' => BaggagePoliticy::class,
                'choice_label' => 'baggagePoliticyname',
                'attr' => ['readonly' => true],
                'label' => 'Политика багажа',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BaggagePoliticyRate::class,
        ]);
    }
}
