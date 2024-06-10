<?php

namespace App\Controller\Frontend;

use App\Manager\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/checkout', name: 'app.checkout')]
class CheckoutController extends AbstractController
{
    public function __construct(
        private CartManager $cartManager
    ) {
    }

    #[Route('/address', name: '.address', methods: ['GET', 'POST'])]
    public function address(): Response
    {
        $cart = $this->cartManager->getCurrentCart();

        if ($cart->getOrderItems()->isEmpty()) {
            $this->addFlash('danger', 'Votre panier est vide, veuillez ajouter des produits avant de continuer.');

            return $this->redirectToRoute('app.cart.show');
        }

        return $this->render('Frontend/Checkout/address.html.twig', [
            'cart' => $cart,
        ]);
    }
}
