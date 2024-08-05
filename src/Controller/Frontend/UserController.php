<?php

namespace App\Controller\Frontend;

use App\Entity\User;
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
    #[Route('/commandes', name: '.orders', methods: ['GET'])]
    public function orders(): Response
    {
        return $this->render('Frontend/User/orders.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response|RedirectResponse
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

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour');

            return $this->redirectToRoute('app.account.edit');
        }

        return $this->render('Frontend/User/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
