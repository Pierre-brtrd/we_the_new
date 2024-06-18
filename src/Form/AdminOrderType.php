<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Order\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AdminOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('id',NumberType::class,[
            'label'=>'id'
        ])
            ->add('number',NumberType::class,[
                'label'=>'Numéro'
            ])
            ->add('status', TextType::class,[
                'label'=>'status'
            ])
            ->add('createdAt', DateType::class, [
               'label'=>'Créé le'
            ])
            ->add('updatedAt', DateType::class, [
                'label'=>'Modifié le'
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
