<?php

namespace App\Entity\Product;

use App\Entity\Traits\DateTimeTrait;
use App\Entity\Traits\EnableTrait;
use App\Repository\Product\GenderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GenderRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Gender
{
    use EnableTrait,
        DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

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
}
