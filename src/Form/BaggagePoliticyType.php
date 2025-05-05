<?php

namespace App\Form;

use App\Entity\BaggagePoliticy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaggagePoliticyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('itemsCount', null, [
                'label' => 'Количество вещей',
            ])
            ->add('weightPerItem', null, [
                'label' => 'Вес на единицу (кг)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BaggagePoliticy::class,
        ]);
    }
}
