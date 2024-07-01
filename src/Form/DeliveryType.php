<?php

namespace App\Form;

use App\Entity\Delivery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DeliveryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'=>'Nom de la méthode de livraison'
            ])
            ->add('description', TextareaType::class,[
                'label'=>'text de livraison',
                'attr'=>[
                    'placeholder'=>"Description de la méthode de livraison",
                    'rows'=>3,
                ],
                'required'=>false,
            ])
            ->add('price', MoneyType::class,[
                'label'=>'Montant de la livraison'
            ] )
            ->add('enable', CheckboxType::class,[
                'label'=>'Actif',
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Delivery::class,
        ]);
    }
}
