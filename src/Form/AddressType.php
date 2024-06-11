<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class, [
                'label' => 'address',
                'attr' => [
                    'class' => 'form-control mb-2 mx-auto mt-2',
                    'placeholder' => '1 rue de la paix',
                ],
            ])
            ->add('zip_code', TextType::class, [
                'label' => 'code postal',
                'attr' => [
                    'class' => 'form-control mb-2 mx-auto',
                    'placeholder' => '38600'
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'ville',
                'attr' => [
                    'placeholder' => 'Paris',
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
