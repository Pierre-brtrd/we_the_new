<?php

namespace App\Form;

use App\Entity\Order\OrderItem;
use App\Entity\Product\ProductVariant;
use App\Repository\Product\ProductVariantRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddToCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productVariant', EntityType::class, [
                'class' => ProductVariant::class,
                'choice_label' => 'size',
                'expanded' => true,
                'multiple' => false,
                'query_builder' => function (ProductVariantRepository $repository) use ($options): QueryBuilder {
                    return $repository->createQueryBuilder('pv')
                        ->andWhere('pv.product = :product')
                        ->setParameter('product', $options['product'])
                        ->orderBy('pv.size', 'ASC');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderItem::class,
            'product' => null,
        ]);
    }
}
