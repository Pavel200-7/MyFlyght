<?php

namespace App\Form;

use App\Entity\HundLuggagePoliticy;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HundLuggagePoliticyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hundLuggagePoliticyname', null, [
                'label' => 'Политика ручной клади',
            ])
            ->add('ItemsCount', null, [
                'label' => 'Количество вещей',
            ])
            ->add('weightPerItem', null, [
                'label' => 'Вес на единицу (кг)',
            ])
            ->add('widthX', null, [
                'label' => 'Ширина (см)',
            ])
            ->add('lengthY', null, [
                'label' => 'Длина (см)',
            ])
            ->add('heightZ', null, [
                'label' => 'Высота (см)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HundLuggagePoliticy::class,
        ]);
    }
}
