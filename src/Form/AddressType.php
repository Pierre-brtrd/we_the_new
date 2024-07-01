<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class, [
                'label'=>'Votre addresse',
                'attr'=>[
                    'placeholder'=>"1 rue de la paix"
                ]
            ])
            ->add('zip_code',TextType::class,[
                'label'=>'Code postal',
                'attr'=>[
                    'placeholder'=>"75000"
                ]
            ])
            ->add('city', TextType::class,[
                'label'=>'Ville',
                'attr'=>[
                    'placeholder'=>"Paris"
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
