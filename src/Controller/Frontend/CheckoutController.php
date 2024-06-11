<?php

namespace App\Controller\Frontend;

use App\Entity\User;
use App\Entity\Address;
use App\Form\AddressType;
use App\Manager\CartManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/checkout', name: 'app.checkout')]
class CheckoutController extends AbstractController
{
    public function __construct(
        private CartManager $cartManager,
        private EntityManagerInterface $em
    ) {
    }

    #[Route('/address', name: '.address')]
    public function address(Request $request): Response
    {

        $cart = $this->cartManager->getCurrentCart();

        if ($cart->getOrderItems()->isEmpty()) {
            $this->addFlash('danger', 'Votre panier est vide');

            return $this->redirectToRoute('app.cart.show');
        }
        /** @var User $user*/
        $user = $this->getUser();

        if ($user->getDefaultAdressId()) {
            $address = clone $user->getDefaultAdressId();
        } elseif (!$user->getAdressId()->isEmpty()) {
            $address = clone $user->getAdressId()->first();
        }else{
            $address=new Address();
        }

        $form=$this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            if(!$user->hasAddress($address)){
                $user->addAdressId($address);

                $this->em->persist($address);
                $this->em->flush();
            }

            return $this->redirectToRoute('app.checkout.shipping');
        }


        return $this->render('Frontend/Checkout/address.html.twig', [
            'cart' => $cart,
            'form'=>$form,
            'addresses'=>$user->getAdressId(),
        ]);
    }
    #[Route('/shipping', name:'.shipping', methods:['GET','POST'])]
    public function shipping(): Response
    {
        dd('shipping');
    }


}
