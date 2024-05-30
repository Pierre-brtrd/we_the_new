<?php

namespace App\Entity\Product;

use App\Entity\Traits\DateTimeTrait;
use App\Entity\Traits\EnableTrait;
use App\Repository\Product\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product
{
    use DateTimeTrait,
        EnableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['name'])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $authenticity = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Gender $gender = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Model $model = null;

    /**
     * @var Collection<int, ProductImage>
     */
    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'product', orphanRemoval: true, cascade: ['persist', 'remove'])]
    // #[Assert\Valid]
    private Collection $images;

    /**
     * @var Collection<int, ProductVariant>
     */
    #[ORM\OneToMany(targetEntity: ProductVariant::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $productVariants;

    /**
     * @var Collection<int, ProductAssociation>
     */
    #[ORM\OneToMany(targetEntity: ProductAssociation::class, mappedBy: 'product', orphanRemoval: true, cascade: ['persist', 'remove'])]
    #[Assert\Valid]
    private Collection $productAssociations;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->productVariants = new ArrayCollection();
        $this->productAssociations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthenticity(): ?string
    {
        return $this->authenticity;
    }

    public function setAuthenticity(?string $authenticity): static
    {
        $this->authenticity = $authenticity;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return Collection<int, ProductImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ProductImage $productImage): static
    {
        if (!$this->images->contains($productImage)) {
            $this->images->add($productImage);
            $productImage->setProduct($this);
        }

        return $this;
    }

    public function removeImage(ProductImage $productImage): static
    {
        if ($this->images->removeElement($productImage)) {
            // set the owning side to null (unless already changed)
            if ($productImage->getProduct() === $this) {
                $productImage->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductVariant>
     */
    public function getProductVariants(): Collection
    {
        return $this->productVariants;
    }

    public function addProductVariant(ProductVariant $productVariant): static
    {
        if (!$this->productVariants->contains($productVariant)) {
            $this->productVariants->add($productVariant);
            $productVariant->setProduct($this);
        }

        return $this;
    }

    public function removeProductVariant(ProductVariant $productVariant): static
    {
        if ($this->productVariants->removeElement($productVariant)) {
            // set the owning side to null (unless already changed)
            if ($productVariant->getProduct() === $this) {
                $productVariant->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductAssociation>
     */
    public function getProductAssociations(): Collection
    {
        return $this->productAssociations;
    }

    public function addProductAssociation(ProductAssociation $productAssociation): static
    {
        if (!$this->productAssociations->contains($productAssociation)) {
            $this->productAssociations->add($productAssociation);
            $productAssociation->setProduct($this);
        }

        return $this;
    }

    public function removeProductAssociation(ProductAssociation $productAssociation): static
    {
        if ($this->productAssociations->removeElement($productAssociation)) {
            // set the owning side to null (unless already changed)
            if ($productAssociation->getProduct() === $this) {
                $productAssociation->setProduct(null);
            }
        }

        return $this;
    }

    public function removeAllProductAssociation(): static
    {
        foreach ($this->productAssociations as $productAssociation) {
            $this->removeProductAssociation($productAssociation);
        }

        return $this;
    }
}
