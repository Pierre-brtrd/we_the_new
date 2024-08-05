<?php

namespace App\Controller\Backend;

use App\Entity\Product\Product;
use App\Entity\Product\ProductVariant;
use App\Form\ProductVariantType;
use App\Repository\Product\ProductVariantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/products-variants', name: 'admin.products-variants')]
class ProductVariantController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ProductVariantRepository $productVariantRepository
    ) {
    }

    #[Route('/list/{id}', name: '.index', methods: ['GET'], defaults: ['id' => null])]
    public function index(?Product $product, Request $request): Response
    {
        if ($product) {
            $productVariants = $this->productVariantRepository->findPaginateOrderByDate(
                $request->query->get('limit', 9),
                $request->query->getInt('page', 1),
                $request->query->get('search'),
                $product,
            );
        } else {
            $productVariants = $this->productVariantRepository->findPaginateOrderByDate(
                $request->query->get('limit', 9),
                $request->query->getInt('page', 1),
                $request->query->get('search'),
            );
        }

        return $this->render('Backend/ProductsVariants/index.html.twig', [
            'productVariants' => $productVariants,
            'product' => $product,
        ]);
    }

    #[Route('/create/{id}', name: '.create', methods: ['GET', 'POST'], defaults: ['id' => null])]
    public function create(Request $request, ?Product $product): Response
    {
        $productVariant = new ProductVariant();

        if ($product) {
            $productVariant->setProduct($product);
        }

        $form = $this->createForm(ProductVariantType::class, $productVariant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($productVariant);
            $this->em->flush();

            $this->addFlash('success', 'La variante de produit a bien été créée.');

            return $this->redirectToRoute('admin.products-variants.index', [
                'id' => $productVariant->getProduct()->getId()
            ]);
        }

        return $this->render('Backend/ProductsVariants/create.html.twig', [
            'form' => $form,
            'product' => $product,
        ]);
    }

    #[Route('/edit/{id}', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(ProductVariant $productVariant, Request $request): Response
    {
        $form = $this->createForm(ProductVariantType::class, $productVariant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'La variante de produit a bien été modifiée.');

            return $this->redirectToRoute('admin.products-variants.index');
        }

        return $this->render('Backend/ProductsVariants/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
