<?php

namespace App\Controller\Frontend;

use App\Entity\Order\OrderItem;
use App\Entity\Product\Model;
use App\Entity\Product\Product;
use App\Filter\ProductFilter;
use App\Form\AddToCartType;
use App\Form\ProductFilterType;
use App\Manager\CartManager;
use App\Repository\Product\ModelRepository;
use App\Repository\Product\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    #[Route('/{slug}', name: '.index', defaults: ['slug' => null], methods: ['GET'])]
    public function index(?Model $model, Request $request): Response
    {
        $filter = (new ProductFilter())
            ->setPage($request->query->getInt('page', 1))
            ->setSort($request->query->get('sort'))
            ->setDirection($request->query->get('direction'))
            ->setLimit($request->query->getInt('limit', 12));

        $form = $this->createForm(ProductFilterType::class, $filter);
        $form->handleRequest($request);

        if ($model) {
            $products = $this->productRepository->createListShop(
                $filter,
                $model,
            );
        } else {
            $products = $this->productRepository->createListShop($filter);
        }

        return $this->render('Frontend/Products/index.html.twig', [
            'currentModel' => $model,
            'models' => $this->modelRepository->findBy(['enable' => true], ['name' => 'ASC']),
            'products' => $products,
            'form' => $form,
        ]);
    }

    #[Route('/details/{slug}', name: '.show', methods: ['GET', 'POST'])]
    public function show(?Product $product, Request $request, CartManager $cartManager): Response|RedirectResponse
    {
        if (!$product) {
            $this->addFlash('error', 'Produit non trouvé');

            return $this->redirectToRoute('app.products.index');
        }

        $orderItem = (new OrderItem)
            ->setQuantity(1);

        $form = $this->createForm(AddToCartType::class, $orderItem, [
            'product' => $product,
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $cart = $cartManager->getCurrentCart();
            $cart->addOrderItem($orderItem);
            $cartManager->save($cart);
            $this->addFlash('success', 'Le produit a été ajouté au panier.');
            return $this->redirectToRoute('app.products.show', [
                'slug' => $product->getSlug(),
            ]);
        }

        return $this->render('Frontend/Products/show.html.twig', [
            'product' => $product,
            'models' => $this->modelRepository->findBy(['enable' => true], ['name' => 'ASC']),
            'form' => $form,
        ]);
    }
}
