<?php

namespace App\Controller\Frontend;

use App\Form\CartType;
use App\Manager\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app.cart.show')]
    public function cart(CartManager $cartManager, Request $request): Response
    {
        $cart = $cartManager->getCurrentCart();

        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $cartManager->save($cart);

            $this->addFlash('success', 'Le panier a été mis à jour');

            return $this->redirectToRoute('app.cart.show');
        }

        return $this->render('Frontend/Cart/index.html.twig', [
            'cart' => $cart,
            'form' => $form,
        ]);
    }
}
