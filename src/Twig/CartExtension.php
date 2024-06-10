<?php 

namespace App\Twig;

use App\Manager\CartManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CartExtension extends AbstractExtension {

    public function __construct(
        private CartManager $cartManager,
    ){}
    public function getFunctions(): array {
        return [
            new TwigFunction('getNumberCartItem', [$this, 'getNumberCartItem']),
        ];
    }

    public function getNumberCartItem(): int {
        $cart = $this->cartManager->getCurrentCart();

        $quantity = 0;

        foreach($cart->getOrderItems() as $orderItem) {
            $quantity += $orderItem->getQuantity();
        }

        return $quantity;
    }
}