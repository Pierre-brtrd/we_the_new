<?php

namespace App\Controller\Backend;

use App\Entity\Order\Order;
use App\Repository\Order\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/orders', name: 'admin.orders')]
class OrderController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly OrderRepository $orderRepository,
    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Orders/index.html.twig', [
            'orders' => $this->orderRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/{id}/show', name: '.show', methods: ['GET'])]
    public function show(?Order $order): Response|RedirectResponse
    {
        if (!$order) {
            $this->addFlash('error', 'Order not found');

            return $this->redirectToRoute('admin.orders.index');
        }

        return $this->render('Backend/Orders/show.html.twig', [
            'order' => $order,
        ]);
    }
}
