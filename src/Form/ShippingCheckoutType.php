<?php

namespace App\Form;

use App\Entity\Delivery\Delivery;
use App\Entity\Delivery\Shipping;
use App\Repository\Delivery\DeliveryRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShippingCheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('delivery', EntityType::class, [
                'class' => Delivery::class,
                'choice_label' => 'name',
                'query_builder' => function (DeliveryRepository $repo): QueryBuilder {
                    return $repo->createQueryBuilder('d')
                        ->andWhere('d.enable = true')
                        ->orderBy('d.name', 'ASC');
                },
                'expanded' => true,
                'multiple' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shipping::class,
        ]);
    }
}
