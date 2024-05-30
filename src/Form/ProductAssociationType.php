<?php

namespace App\Form;

use App\Entity\Product\Product;
use App\Entity\Product\ProductAssociation;
use App\Repository\Product\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductAssociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('associatedProduct', EntityType::class, [
                'label' => 'Produits associés',
                'class' => Product::class,
                'choice_label' => 'name',
                'query_builder' => fn (ProductRepository $productRepository) => $productRepository->createQueryBuilder('p')
                    ->andWhere('p.enable = :enable')
                    ->setParameter('enable', true)
                    ->orderBy('p.name', 'ASC'),
                'expanded' => false,
                'multiple' => true,
                'autocomplete' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductAssociation::class,
        ]);
    }
}
