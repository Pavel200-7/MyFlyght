<?php

namespace App\Form;

use App\Entity\SeatsDiscriptionShablon;
use App\Enum\CompartmentTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeatsDiscriptionShablonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('SeatsDiscriptionShablonName', null, [
                'label' => 'Наименование шаблона',
            ])
            ->add('ClassType', EnumType::class , [
                'class' => CompartmentTypeEnum::class,
                'label' => 'Тип класса',
                'mapped' => false,
                'choice_label' => 'value',
            ])
            ->add('SeatShablonJSOn', TextareaType::class, [
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeatsDiscriptionShablon::class,
        ]);
    }
}
