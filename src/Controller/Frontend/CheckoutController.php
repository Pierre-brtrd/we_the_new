<?php

namespace App\Controller\Frontend;

use App\Entity\Delivery;
use App\Entity\User;
use App\Entity\Adress;
use App\Form\AddressType;
use App\Form\DeliveryType;
use App\Manager\CartManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/checkout', name: 'app.checkout')]
class CheckoutController extends AbstractController
{

    public function __construct(
        private CartManager $cartManager,
        private EntityManagerInterface $em,
    ) {}

    #[Route('/address', name: '.address', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $cart = $this->cartManager->getCurrentCart();

        if($cart->getOrderItems()->isEmpty()) {
            $this->addFlash('danger', 'Votre panier est vide, veuillez ajouter des produits avant de continuer.');

            return $this->redirectToRoute('app.cart.show');
        }

        /** @var User $user */
        $user = $this->getUser();
        if($user->getDefaultAddress()) {
            $address = clone $user->getDefaultAddress();
        } elseif (!$user->getAddresses()->isEmpty()) {
            $address = clone $user->getAddresses()->first();
        } else {
            $address = (new Adress());
        }

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if(!$user->hasAddress($address)) {
                $user->addAddress($address);

                $this->em->persist($address);
                $this->em->flush();
            }

            return $this->redirectToRoute('app.checkout.shipping');
        }

        return $this->render('Frontend/Checkout/address.html.twig', [
            'cart' => $cart,
            'form' => $form,
            'addresses' => $user->getAddresses(),
        ]);
    }
}
