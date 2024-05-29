<?php

namespace App\Twig;

use App\Entity\Product\Product;
use App\Entity\Product\ProductImage;
use Twig\Extension\AbstractExtension;

class ProductImageExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new \Twig\TwigFilter('main_image', [$this, 'getMainImage']),
        ];
    }

    public function getMainImage(Product $product): ?ProductImage
    {
        $mainImage = array_filter($product->getImages()->toArray(), function (ProductImage $productImage): ?ProductImage {
            if ($productImage->getType() === 'main') {
                return $productImage;
            }

            return null;
        });

        return array_shift($mainImage) ?? null;
    }
}
