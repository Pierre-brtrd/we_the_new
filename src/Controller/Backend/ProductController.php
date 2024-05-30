<?php

namespace App\Controller\Backend;

use App\Entity\Product\Product;
use App\Entity\Product\ProductAssociation;
use App\Form\ProductType;
use App\Repository\Product\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/products', name: 'admin.products')]
class ProductController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ProductRepository $productRepository
    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->render('Backend/Products/index.html.twig', [
            'products' => $this->productRepository->findPaginateOrderByDate(
                $request->query->getInt('limit', 9),
                $request->query->getInt('page', 1),
                $request->query->get('search')
            ),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $associatedProducts = $form->get('productAssociations')->getData();

            foreach ($associatedProducts as $associatedProduct) {
                $associatedProduct->setProduct($product);

                $this->em->persist($associatedProduct);
            }

            $this->em->persist($product);
            $this->em->flush();

            $this->addFlash('success', 'Le produit a bien été créé.');

            return $this->redirectToRoute('admin.products.index');
        }

        return $this->render('Backend/Products/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: '.edit', methods: ['GET', 'POST'])]
    public function edit(?Product $product, Request $request): Response
    {
        if (!$product) {
            $this->addFlash('danger', 'Le produit n\'existe pas.');

            return $this->redirectToRoute('admin.products.index');
        }

        $form = $this->createForm(ProductType::class, $product);

        // Pré-remplir les produits associés
        $associatedProducts = $product->getProductAssociations();
        $form->get('productAssociations')->setData($associatedProducts);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->removeAllProductAssociation();

            $associatedProducts = $form->get('productAssociations')->getData();

            foreach ($associatedProducts as $associatedProduct) {
                $associatedProduct->setProduct($product);

                $this->em->persist($associatedProduct);
            }

            $this->em->flush();

            $this->addFlash('success', 'Le produit a bien été modifié.');

            return $this->redirectToRoute('admin.products.index');
        }

        return $this->render('Backend/Products/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?Product $product, Request $request): Response
    {
        if (!$product) {
            $this->addFlash('danger', 'Le produit n\'existe pas.');

            return $this->redirectToRoute('admin.products.index');
        }

        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('token'))) {
            $this->em->remove($product);
            $this->em->flush();

            $this->addFlash('success', 'Le produit a bien été supprimé.');
        }

        return $this->redirectToRoute('admin.products.index');
    }
}
