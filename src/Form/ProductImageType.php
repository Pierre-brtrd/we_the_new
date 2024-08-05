<?php

namespace App\Form;

use App\Entity\Product\ProductImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageType', ChoiceType::class, [
                'label' => 'Type d\'image',
                'placeholder' => 'Choisir un type',
                'choices' => [
                    'Image principale' => ProductImage::IMAGE_TYPE_MAIN,
                    'Image secondaire' => ProductImage::IMAGE_TYPE_SECONDARY,
                ]
            ])
            ->add('image', VichImageType::class, [
                'label' => 'Image',
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductImage::class,
        ]);
    }
}
