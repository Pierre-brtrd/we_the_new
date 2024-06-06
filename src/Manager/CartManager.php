<?php

namespace App\Manager;

use App\Entity\Order\Order;
use App\Factory\OrderFactory;
use App\Storage\CartSessionStorage;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Order\OrderRepository;
use Symfony\Bundle\SecurityBundle\Security;

class CartManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private OrderFactory $orderFactory,
        private CartSessionStorage $cartSessionStorage,
        private Security $security,
        private OrderRepository $orderRepository,

    ) {
    }

    public function getCurrentcart(): Order
    {
        $cart = $this->cartSessionStorage->getCart();

        $user = $this->security->getUser();

        if (!$cart) {

            if ($user) {
                $cart = $this->orderRepository->findLastCartByUser($user);
            }
        } else if (!$cart->getUser() && $user) {
            $cart->setUser($user);

            $cartDb = $this->orderRepository->findLastCartByUser($user);

            if ($cartDb) {
                $cart = $this->mergeCart($cartDb, $cart);
            }
        }

        return $cart ?? $this->orderFactory->create();
    }

    public function save(Order $order): void
    {
        $this->cartSessionStorage->setCart($order);
        $this->em->persist($order);
        $this->em->flush();
    }

    public function mergeCart(Order $cartDb, Order $cartSession): Order
    {
        foreach ($cartDb->getOrderItems() as $item) {
            $cartSession->addOrderItem($item);
        }
        $this->em->remove($cartDb);
        $this->em->flush();

        return $cartSession;
    }
}
