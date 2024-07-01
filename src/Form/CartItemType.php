<?php

namespace App\Form;

use App\Entity\Order\Order;
use App\Entity\Order\OrderItem;
use App\Entity\Product\ProductVariant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CartItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', ChoiceType::class, [
                'label' => false,
                'choices' => $this->getQuantityChoices(),
            ])
            ->add('remove', SubmitType::class, [
                'label'=>'Supprimer',
                'attr'=>[
                'class'=>'btn btn-danger',
                ]
                ])
                ;
    }

    private function getQuantityChoices(): array
    {
        for($i=1; $i<=10; $i++){
            $choices[$i]= $i;
        }
        return $choices;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderItem::class,
        ]);
    }
}
