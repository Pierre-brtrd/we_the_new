<?php

namespace App\Factory;

use App\Entity\Order\Order;
use App\Entity\Order\OrderItem;
use App\Entity\Product\ProductVariant;
use Symfony\Bundle\SecurityBundle\Security;

class OrderFactory
{

    public function __construct(
        private Security $security
    ) {
    }

    public function create(): Order
    {
        $order = (new Order)
            ->setStatus(Order::STATUS_CART);

        if ($this->security->getUser()) {
            $order
                ->setUser($this->security->getUser());
        }

        return $order;
    }

    public function createItem(ProductVariant $productVariant): OrderItem
    {
        return (new OrderItem)
        ->setProductVariant($productVariant)
        ->setQuantity(1);
    }
}
