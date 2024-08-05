<?php

namespace App\Form\DataTransformer;

use App\Entity\Product\Product;
use App\Entity\Product\ProductAssociation;
use App\Repository\Product\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ProductAssociationsTransformer implements DataTransformerInterface
{
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    /**
     * Transforms an array of ProductAssociations to an array of Products.
     *
     * @param Collection|null $productAssociations
     * @return array
     */
    public function transform($productAssociations): array
    {
        if (null === $productAssociations) {
            return [];
        }

        return array_map(function ($association) {
            return $association->getAssociatedProduct();
        }, $productAssociations->toArray());
    }

    /**
     * Transforms an array of Products to an array of ProductAssociations.
     *
     * @param array $products
     * @return Collection
     */
    public function reverseTransform($products): Collection
    {
        if (!$products) {
            return new ArrayCollection();
        }

        $associations = new ArrayCollection();

        foreach ($products as $product) {
            if (!$product instanceof Product) {
                throw new TransformationFailedException(sprintf('Expected a Product, got "%s"', get_class($product)));
            }
            $association = new ProductAssociation();
            $association->setAssociatedProduct($product);
            $associations->add($association);
        }

        return $associations;
    }
}
