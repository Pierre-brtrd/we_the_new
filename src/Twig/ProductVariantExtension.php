<?php

namespace App\Twig;

use App\Entity\Product\Product;
use App\Entity\Product\ProductVariant;
use App\Repository\Product\ProductVariantRepository;
use Twig\Extension\AbstractExtension;

class ProductVariantExtension extends AbstractExtension
{
    public function __construct(
        private readonly ProductVariantRepository $productVariantRepository,
    ) {
    }

    public function getFilters(): array
    {
        return [
            new \Twig\TwigFilter('resolve_chepeast_variant', [$this, 'getCheapestVariant']),
        ];
    }

    public function getCheapestVariant(Product $product): ?ProductVariant
    {
        return $this->productVariantRepository->findCheapestVariant($product);
    }
}
