<?php

namespace App\Form;

use App\Entity\Product\Gender;
use App\Entity\Product\Model;
use App\Entity\Product\Product;
use App\Form\ProductImageType;
use App\Repository\Product\GenderRepository;
use App\Repository\Product\ModelRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom du produit',
                ]
            ])
            ->add('gender', EntityType::class, [
                'label' => 'Genre',
                'placeholder' => 'Choisir un genre',
                'class' => Gender::class,
                'choice_label' => 'name',
                'query_builder' => fn (GenderRepository $genderRepository) => $genderRepository->createQueryBuilder('g')
                    ->andWhere('g.enable = :enable')
                    ->setParameter('enable', true)
                    ->orderBy('g.name', 'ASC'),
                'expanded' => false,
                'multiple' => false,
                'autocomplete' => true,
            ])
            ->add('model', EntityType::class, [
                'label' => 'Modèle',
                'placeholder' => 'Choisir un modèle',
                'class' => Model::class,
                'choice_label' => 'name',
                'query_builder' => fn (ModelRepository $modelRepository) => $modelRepository->createQueryBuilder('m')
                    ->andWhere('m.enable = :enable')
                    ->setParameter('enable', true)
                    ->orderBy('m.name', 'ASC'),
                'expanded' => false,
                'multiple' => false,
                'autocomplete' => true,
            ])
            ->add('images', CollectionType::class, [
                'label' => 'Images',
                'entry_type' => ProductImageType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'delete_empty' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Description du produit',
                    'rows' => 5,
                ]
            ])
            ->add('authenticity', TextareaType::class, [
                'label' => 'Authenticité',
                'attr' => [
                    'placeholder' => 'Authenticité du produit',
                    'rows' => 3,
                ],
                'required' => false,
            ])
            ->add('enable', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
