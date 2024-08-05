<?php

namespace App\Controller\Frontend;

use App\Repository\Product\MarqueRepository;
use App\Repository\Product\ModelRepository;
use App\Repository\Product\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly MarqueRepository $marqueRepository,
        private readonly ModelRepository $modelRepository
    ) {
    }

    #[Route('', name: 'app.home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Frontend/Home/index.html.twig', [
            'marques' => $this->marqueRepository->findBy(['enable' => true], ['name' => 'ASC']),
            'models' => $this->modelRepository->findBy(['enable' => true], ['name' => 'ASC']),
            'products' => $this->productRepository->findShopLatest(4),
        ]);
    }
}
