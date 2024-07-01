<?php

namespace App\Controller\Backend;

use App\Entity\Order\Order;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Order\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/order', name: "admin.adminOrder")]
class AdminOrderController extends AbstractController
{

    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly EntityManagerInterface $em

    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {

        return $this->render('Backend/AdminOrder/index.html.twig', [
            'orders' => $this->orderRepository->findAll(),
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: 'POST')]
    public function delete(Order $order, Request $request): RedirectResponse
    {
        if (!$order) {
            $this->addFlash('error', 'Commande non trouvée');
            return $this->redirectToRoute('app.adminOrder');
        }

        if ($this->isCsrfTokenValid('delete' . $order->getId(), $request->request->get('token'))) {
            $this->em->remove($order);
            $this->em->flush();
        } else {
            $this->addFlash('error', 'Token CSRF invalide');

            return $this->redirectToRoute('app.adminOrder');
        }
        $this->addFlash('success', 'Commande supprimée avec succès');

        return $this->redirectToRoute('app.adminOrder');
    }

    #[Route('/{id}/show',name:'.show', methods:['GET'])]
    public function show(Order $order): Response |RedirectResponse
    {
        if(!$order){
            $this->addFlash('error', 'Commande non trouvée');

            return $this->redirectToRoute('app.admin');
        }

        return $this->render('');
    }
}
