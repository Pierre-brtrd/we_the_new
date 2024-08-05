<?php

namespace App\Controller\Frontend;

use App\Entity\Address;
use App\Entity\User;
use App\Form\AddressType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/compte', name: 'app.account')]
class UserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    #[Route('/commandes', name: '.orders', methods: ['GET'])]
    public function orders(): Response
    {
        return $this->render('Frontend/User/orders.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserPasswordHasherInterface $hasher): Response|RedirectResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user, ['isEdit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('password')->getData()) {
                $user->setPassword(
                    $hasher->hashPassword($user, $form->get('password')->getData())
                );
            }

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour');

            return $this->redirectToRoute('app.account.edit');
        }

        return $this->render('Frontend/User/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/adresses', name: '.address', methods: ['GET'])]
    public function address(): Response
    {
        return $this->render('Frontend/User/address.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/adresse/nouveau', name: '.address.new', methods: ['GET', 'POST'])]
    public function newAddress(Request $request): Response|RedirectResponse
    {
        $address = new Address();
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->addAddress($address);

            $this->em->persist($address);
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'Adresse ajoutée à votre carnet');

            return $this->redirectToRoute('app.account.address');
        }

        return $this->render('Frontend/User/newAddress.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/adresse/default/{id}', name: '.address.default', methods: ['GET'])]
    public function setDefaultAddress(?Address $address): RedirectResponse
    {
        if (!$address) {
            $this->addFlash('error', 'Adresse non trouvée');

            return $this->redirectToRoute('app.account.address');
        }

        /** @var User $user */
        $user = $this->getUser();

        $user->setDefaultAddress($address);

        $this->em->persist($user);
        $this->em->flush();

        $this->addFlash('success', 'Votre adresse principale vient d\'être mise à jour');

        return $this->redirectToRoute('app.account.address');
    }
}
