<?php

namespace App\Manager;

use App\Entity\Order\Order;
use App\Factory\OrderFactory;
use App\Storage\CartSessionStorage;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Order\OrderRepository;
use Symfony\Bundle\SecurityBundle\Security;

class CartManager {
    
    public function __construct(
        private EntityManagerInterface $em,
        private OrderFactory $orderFactory,
        private CartSessionStorage $cartSessionStorage,
        private Security $security,
        private OrderRepository $orderRepository,
    ) {}

    /**
     * Get the current cart of the User
     *
     * @return Order
     */
    public function getCurrentCart(): Order {
        $cart = $this->cartSessionStorage->getCart();

        //vérifier si l'user est connecté
        $user = $this->security->getUser();

        if(!$cart) {
            if($user){
                //si l'user est connecté et qu'il n'y a pas de panier en session, on récupère le dernier panier enregistré en BDD pour ce user
                $cart = $this->orderRepository->findLastCartByUser($user);
            }
        
            //si on a un panier en session sans user, et que l'user vient de se connecter, on lui rattache le panier
        } elseif (!$cart->getUser() && $user) {
            $cart->setUser($user);

            //on récupère le dernier panier de l'user en BDD
            $cartDB = $this->orderRepository->findLastCartByUser($user);

            //si l'user avait déjà un panier, on fusionne les paniers
            if($cartDB) {
                $cart = $this->mergeCart($cartDB, $cart);
            }
        }

        //si le panier est défini, renvoie le, sinon créé le
        return $cart ?? $this->orderFactory->create();
    }

    /**
     * Save the cart
     *
     * @return void
     */
    public function save(Order $order): void {
        $this->em->persist($order);
        $this->em->flush();
        $this->cartSessionStorage->setCart($order);
    }

    private function mergeCart(Order $cartDB, Order $cartSession): Order {
        foreach($cartDB->getOrderItems() as $item) {
            $cartSession->addOrderItem($item);
        }

        $this->em->remove($cartDB);
        $this->em->flush();

        return $cartSession;
    }
}