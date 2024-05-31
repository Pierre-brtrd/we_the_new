<?php

namespace App\Controller\Frontend;

use App\Entity\Product\Model;
use App\Repository\Product\ModelRepository;
use App\Repository\Product\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sneakers', name: 'app.products')]
class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ModelRepository $modelRepository,
    ) {
    }

    #[Route('/{slug}', name: '.index', defaults: ['slug' => null])]
    public function index(?Model $model, Request $request): Response
    {
        if ($model) {
            $products = $this->productRepository->findShopPaginateOrderByDate(
                $request->query->getInt('limit', 12),
                $request->query->getInt('page', 1),
                $request->query->get('search'),
                $model,
            );
        } else {
            $products = $this->productRepository->findShopPaginateOrderByDate(
                $request->query->getInt('limit', 12),
                $request->query->getInt('page', 1),
                $request->query->get('search'),
            );
        }

        return $this->render('Frontend/Products/index.html.twig', [
            'currentModel' => $model,
            'models' => $this->modelRepository->findBy(['enable' => true], ['name' => 'ASC']),
            'products' => $products,
        ]);
    }
}
