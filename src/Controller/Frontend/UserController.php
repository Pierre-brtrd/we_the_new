<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
}
