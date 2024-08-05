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

    public function getFunctions(): array
    {
        return [
            new \Twig\TwigFunction('priceTTC', [$this, 'getPriceTTC']),
        ];
    }

    public function getCheapestVariant(Product $product): ?ProductVariant
    {
        return $this->productVariantRepository->findCheapestVariant($product);
    }

    public function getPriceTTC(ProductVariant $productVariant): float
    {
        return $productVariant->getPriceHT() * (1 + $productVariant->getTaxe()->getRate());
    }
}
