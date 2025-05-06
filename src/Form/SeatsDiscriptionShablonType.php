<?php

namespace App\Form;

use App\Entity\SeatsDiscriptionShablon;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SeatsDiscriptionShablon::class,
        ]);
    }
}
