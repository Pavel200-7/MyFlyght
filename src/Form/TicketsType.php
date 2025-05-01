<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\Flights;
use App\Entity\FlightsSeats;
use App\Entity\Tickets;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('finished')
            ->add('timestamp', null, [
                'widget' => 'single_text',
            ])
            ->add('flightId', EntityType::class, [
                'class' => Flights::class,
                'choice_label' => 'id',
            ])
            ->add('flightSeatsId', EntityType::class, [
                'class' => FlightsSeats::class,
                'choice_label' => 'id',
            ])
            ->add('clientId', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tickets::class,
        ]);
    }
}
