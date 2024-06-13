<?php

namespace App\Controller\Backend;

use App\Entity\Delivery\Delivery;
use App\Form\DeliveryFormType;
use App\Repository\Delivery\DeliveryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/delivery', name: 'admin.delivery', methods: ['GET', 'POST'])]
class DeliveryController extends AbstractController
{   

    public function __construct(
        private EntityManagerInterface $em,
    ){}

    #[Route('', name: '.index', methods: ['GET', 'POST'])]
    public function index(DeliveryRepository $deliveryRepository): Response
    {
        return $this->render('backend/delivery/index.html.twig', [
            'deliverys' => $deliveryRepository->findALl(),
        ]);
    }

    #[Route('/create', name: '.create', methods:['POST', 'GET'])]
    public function createDelivery(Request $request): Response|RedirectResponse {
        
        $delivery = new Delivery;

        $form = $this->createForm(DeliveryFormType::class, $delivery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($delivery);
            $this->em->flush();

            $this->addFlash('success', 'Delivery was successfully created');
            return $this->redirectToRoute('admin.delivery.index');
        } 

        return $this->render('Backend/Delivery/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/update', name: '.update', methods: ['GET', 'POST'])]
    public function edit(?Delivery $delivery, Request $request): Response|RedirectResponse
    {
        if (!$delivery) {
            $this->addFlash('error', 'Livraison introuvable');

            return $this->redirectToRoute('admin.delivery.index');
        }

        $form = $this->createForm(DeliveryFormType::class, $delivery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($delivery);
            $this->em->flush();

            $this->addFlash('success', 'La livraison à été mise a jour');

            return $this->redirectToRoute('admin.delivery.index');
        }

        return $this->render('Backend/Delivery/update.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function deleteDelivery(?Delivery $delivery, Request $request): RedirectResponse {
        if (!$delivery) {
            $this->addFlash('error', 'Livraison introuvable');
            $this->redirectToRoute('admin.delivery.index');
        }

        if ($this->isCsrfTokenValid('delete' . $delivery->getId(), $request->request->get('token'))) {
            $this->em->remove($delivery);
            $this->em->flush();
        } else {
            $this->addFlash('error', 'Token csrf invalide');
        }

        return $this->redirectToRoute('admin.delivery.index');
    }
}
