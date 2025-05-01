<?php

namespace App\Form;

use App\Entity\HundLuggagePoliticy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HundLuggagePoliticyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ItemsCount')
            ->add('weightPerItem')
            ->add('widthX')
            ->add('lengthY')
            ->add('heightZ')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HundLuggagePoliticy::class,
        ]);
    }
}
