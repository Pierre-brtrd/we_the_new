<?php

namespace App\Controller\Backend;

use App\Entity\Order\Order;
use App\Repository\Order\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/orderadmin', name: 'admin.orderadmin')]
class OrderAdminController extends AbstractController
{
    public function __construct (
        private readonly EntityManagerInterface $em,
        private readonly OrderRepository $orderRepository,
    ) {}

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/OrderAdmin/index.html.twig', [
            'ordersadmin' => $this->orderRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/{id}/show', name: '.show', methods: ['GET', 'POST'])]
    public function show(?Order $order): Response|RedirectResponse
    {
        if(!$order) {
            $this->addFlash('error', 'Commande non trouvée');

            return $this->redirectToRoute('admin.orderadmin.index');
        }

        return $this->render('Backend/OrderAdmin/show.html.twig', [
            'order' => $order,

        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?Order $order, Request $request): RedirectResponse
    {
        if (!$order) {
            $this->addFlash('error', 'Genre non trouvé');

            return $this->redirectToRoute('admin.orderadmin.index');
        }

        if ($this->isCsrfTokenValid('delete' . $order->getId(), $request->request->get('token'))) {
            $this->em->remove($order);
            $this->em->flush();
        } else {
            $this->addFlash('error', 'Token invalide');
        }

        return $this->redirectToRoute('admin.orderadmin.index');

    }
}
