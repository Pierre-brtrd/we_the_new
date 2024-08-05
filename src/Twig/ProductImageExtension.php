<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ProductImageExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('main_image', [$this, 'getMainImage'])
        ];
    }

    public function getMainImage()
    {
        // TODO: Implement getMainImage() method.   
    }
}
