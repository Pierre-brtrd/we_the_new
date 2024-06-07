<?php

namespace App\Form;

use App\Entity\Order\Order;
use App\Entity\Order\OrderItem;
use App\Entity\Product\ProductVariant;
use App\Entity\User;
use App\Repository\Product\ProductVariantRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddToCartFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('productVariant', EntityType::class, [
                'class' => ProductVariant::class,
                'choice_label' => 'size',
                'expanded' => true,
                'query_builder' => function (ProductVariantRepository $repository) use ($options): QueryBuilder {
                    return $repository->createQueryBuilder('pv')
                        ->orderBy('pv.size', 'ASC')
                        ->andWhere('pv.product = :product')
                        ->setParameter('product', $options['product']);
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderItem::class,
            'product' => null,
        ]);
    }
}
