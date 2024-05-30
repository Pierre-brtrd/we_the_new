<?php

namespace App\Form;

use App\Entity\Product\Product;
use App\Entity\Product\ProductVariant;
use App\Entity\Taxe;
use App\Repository\TaxeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductVariantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
                'label' => 'Produit',
                'placeholder' => 'Choisir un produit',
            ])
            ->add('priceHT', MoneyType::class, [
                'label' => 'Prix HT',
                'currency' => 'EUR',
                'attr' => [
                    'placeholder' => 'Prix du produit'
                ]
            ])
            ->add('taxe', EntityType::class, [
                'class' => Taxe::class,
                'label' => 'Taux de TVA',
                'placeholder' => 'Taux de TVA',
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
                'autocomplete' => true,
                'query_builder' => function (TaxeRepository $taxeRepository) {
                    return $taxeRepository->createQueryBuilder('t')
                        ->where('t.enable = true')
                        ->orderBy('t.name', 'ASC');
                },
            ])
            ->add('size', ChoiceType::class, [
                'label' => 'Taille',
                'placeholder' => 'Taille du produit',
                'choices' => $this->getSizeChoices(),
            ]);
    }

    private function getSizeChoices(): array
    {
        $choices = range(36, 47);
        $output = [];
        foreach ($choices as $choice) {
            $output[$choice] = $choice;
        }
        return $output;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductVariant::class,
        ]);
    }
}
