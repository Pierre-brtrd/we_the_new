<?php

namespace App\Manager;

use App\Entity\Order\Order;
use App\Factory\OrderFactory;
use App\Repository\Order\OrderRepository;
use App\Storage\CartSessionStorage;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * Get the current cart of the user
     *
     * @return Order
     */
    public function getCurrentCart(): Order
    {
        $cart = $this->cartSessionStorage->getCart();

        // On vérifie si un utilisateur est connecté actuellement
        $user = $this->security->getUser();

        if (!$cart) {
            if ($user) {
                // Si l'utilisateur est connecté et qu'il n'y a pas de panier en session, 
                // on récupère le dernier panier enregistré en base
                $cart = $this->orderRepository->findLastCartByUser($user);
            }
            // Si on a un panier en session sans utilisateur
            // Et qu'on a un utilisateur de connecter
            // On veut rattacher le panier en session à l'utilisateur connecté
        } else if (!$cart->getUser() && $user) {
            $cart->setUser($user);

            // On récupère le dernier panier de l'utilisateur enregistré en base
            $cartDb = $this->orderRepository->findLastCartByUser($user);

            // Si l'utilisateur avait déjà un panier, on fusionne les paniers
            if ($cartDb) {
                $cart = $this->mergeCart($cartDb, $cart);
            }
        }

        return $cart ?? $this->orderFactory->create();
    }

    /**
     * Save the cart in the database
     *
     * @param Order $order
     */
    public function save(Order $order): void
    {
        $this->cartSessionStorage->setCart($order);

        $this->em->persist($order);
        $this->em->flush();
    }

    private function mergeCart(Order $cartDb, Order $cartSession): Order
    {
        foreach ($cartDb->getOrderItems() as $item) {
            $cartSession->addOrderItem($item);
        }

        $this->em->remove($cartDb);
        $this->em->flush();

        return $cartSession;
    }
}
