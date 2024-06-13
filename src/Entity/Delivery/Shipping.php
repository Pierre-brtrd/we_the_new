<?php

namespace App\Entity\Delivery;

use App\Entity\Order\Order;
use App\Entity\Traits\DateTimeTrait;
use App\Repository\Delivery\ShippingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ShippingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Shipping
{
    use DateTimeTrait;

    public const STATUS_NEW = 'new';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_DONE = 'done';
    public const STATUS_CANCEL = 'cancel';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: [
        self::STATUS_NEW,
        self::STATUS_SHIPPED,
        self::STATUS_DONE,
        self::STATUS_CANCEL,
    ])]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'shippings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $orderRef = null;

    #[ORM\ManyToOne(inversedBy: 'shippings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Delivery $delivery = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getOrderRef(): ?Order
    {
        return $this->orderRef;
    }

    public function setOrderRef(?Order $orderRef): static
    {
        $this->orderRef = $orderRef;

        return $this;
    }

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(?Delivery $delivery): static
    {
        $this->delivery = $delivery;

        return $this;
    }
}
