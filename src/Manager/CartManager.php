<?php 

namespace App\Manager;

use App\Entity\Order\Order;
use App\Factory\OrderFactory;
use App\Repository\Order\OrderRepository;
use App\Storage\CartSessionStorage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class CartManager {

    public function __construct(
        private EntityManagerInterface $em,
        private OrderFactory $orderFactory,
        private CartSessionStorage $cartSessionStorage,
        private Security $security,
        private OrderRepository $orderRepository,
        
    ){
    }
    
    // Get the current cart of the user
    public function getCurrentCart(): Order {
        $cart = $this->cartSessionStorage->getCart();

        // On vérfie si un utilisateur est connecté

        $user = $this->security->getUser();

        if (!$cart) {
            if ($user) {
                // Si l'utilisateur est connecté et qu'il n'a pas de panier en session
                // On récupère le dernier panier enregistré en bdd pour cet utilisateur
                $cart = $this->orderRepository->findLastCartByUser($user);
            }
        } elseif (!$cart->getUser() && $user) {
            $cart->setUser($user);

            // On récupère le dernier panier de l'utilisateur enregistré en base
            $cartDb = $this->orderRepository->findLastCartByUser($user);

            // Si l'utilisateur avait déja un panier, on fusionne les paniers
            if ($cartDb) {
                $cart = $this->mergeCart($cartDb, $cart);
            }
        }

        return $cart ?? $this->orderFactory->create();
    }


    // Save the cart in database
    public function saveCart(Order $order): void {

        $this->em->persist($order);
        $this->em->flush();

        $this->cartSessionStorage->setCart($order);

    }

    private function mergeCart(Order $cartDb,Order $cartSession ): Order {

        foreach($cartDb->getOrderItems() as $item) {
            $cartSession->addOrderItem($item);
        }

        $this->em->remove($cartDb);
        $this->em->flush();

        return $cartSession;
    }
}