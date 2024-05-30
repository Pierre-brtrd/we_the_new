<?php

namespace App\Entity\Product;

use App\Repository\Product\ProductAssociationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProductAssociationRepository::class)]
#[UniqueEntity(fields: ['product', 'associatedProduct'])]
class ProductAssociation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'productAssociations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $associatedProduct = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getAssociatedProduct(): ?Product
    {
        return $this->associatedProduct;
    }

    public function setAssociatedProduct(?Product $associatedProduct): static
    {
        $this->associatedProduct = $associatedProduct;

        return $this;
    }
}
