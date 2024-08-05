<?php

namespace App\Controller\Backend;

use App\Entity\Product\Gender;
use App\Form\GenderType;
use App\Repository\Product\GenderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/gender', name: 'admin.genders')]
class GenderController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private GenderRepository $genderRepository
    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Genders/index.html.twig', [
            'genders' => $this->genderRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $gender = new Gender;

        $form = $this->createForm(GenderType::class, $gender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($gender);
            $this->em->flush();

            $this->addFlash('success', 'Le genre a bien été créé.');

            return $this->redirectToRoute('admin.genders.index');
        }

        return $this->render('Backend/Genders/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(?Gender $gender, Request $request): Response|RedirectResponse
    {
        if (!$gender) {
            $this->addFlash('error', 'Genre non trouvé');

            return $this->redirectToRoute('admin.genders.index');
        }

        $form = $this->createForm(GenderType::class, $gender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($gender);
            $this->em->flush();

            $this->addFlash('success', 'Le genre a bien été mis à jour.');

            return $this->redirectToRoute('admin.genders.index');
        }

        return $this->render('Backend/Genders/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?Gender $gender, Request $request): RedirectResponse
    {
        if (!$gender) {
            $this->addFlash('error', 'Genre non trouvé');

            return $this->redirectToRoute('admin.genders.index');
        }

        if ($this->isCsrfTokenValid('delete' . $gender->getId(), $request->request->get('token'))) {
            $this->em->remove($gender);
            $this->em->flush();
        } else {
            $this->addFlash('error', 'Token invalide');
        }

        return $this->redirectToRoute('admin.genders.index');
    }

    #[Route('/{id}/switch', name: '.switch', methods: ['GET'])]
    public function switch(?Gender $gender): JsonResponse
    {
        if (!$gender) {
            return $this->json([
                'status' => 'Error',
                'message' => 'Gender not found',
            ], 404);
        }

        $gender->setEnable(!$gender->isEnable());

        $this->em->flush();

        return $this->json([
            'satus' => 'success',
            'message' => 'Visibility changed',
            'enable' => $gender->isEnable(),
        ]);
    }
}
