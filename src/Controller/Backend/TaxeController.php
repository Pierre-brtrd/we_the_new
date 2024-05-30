<?php

namespace App\Controller\Backend;

use App\Entity\Taxe;
use App\Form\TaxeType;
use App\Repository\TaxeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/taxes', name: 'admin.taxes')]
class TaxeController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly TaxeRepository $taxeRepository,
    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Taxes/index.html.twig', [
            'taxes' => $this->taxeRepository->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $taxe = new Taxe();

        $form = $this->createForm(TaxeType::class, $taxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($taxe);
            $this->em->flush();

            return $this->redirectToRoute('admin.taxes.index');
        }

        return $this->render('Backend/Taxes/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(?Taxe $taxe, Request $request): Response
    {
        if (!$taxe) {
            $this->addFlash('error', 'Taxe non trouvée');

            return $this->redirectToRoute('admin.taxes.index');
        }

        $form = $this->createForm(TaxeType::class, $taxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('admin.taxes.index');
        }

        return $this->render('Backend/Taxes/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '.delete', methods: ['POST'])]
    public function delete(?Taxe $taxe, Request $request): Response
    {
        if (!$taxe) {
            $this->addFlash('error', 'Taxe non trouvée');

            return $this->redirectToRoute('admin.taxes.index');
        }

        if ($this->isCsrfTokenValid('delete' . $taxe->getId(), $request->request->get('token'))) {
            $this->em->remove($taxe);
            $this->em->flush();
        } else {
            $this->addFlash('error', 'Token CSRF invalide');
        }

        return $this->redirectToRoute('admin.taxes.index');
    }
}
