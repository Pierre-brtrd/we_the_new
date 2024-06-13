<?php

namespace App\Entity\Order;

use App\Entity\Delivery\Shipping;
use App\Entity\Traits\DateTimeTrait;
use App\Entity\User;
use App\Repository\Order\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[UniqueEntity(fields: ['number'])]
#[ORM\HasLifecycleCallbacks]
class Order
{
    use DateTimeTrait;

    public const STATUS_NEW = 'new';
    public const STATUS_CART = 'cart';
    public const STATUS_AWAITING_PAYMENT = 'awaiting_payment';
    public const STATUS_SHIPPING = 'shipping';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELED = 'canceled';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $number = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    #[Assert\Choice(
        choices: [
            self::STATUS_CART,
            self::STATUS_NEW,
            self::STATUS_AWAITING_PAYMENT,
            self::STATUS_SHIPPING,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELED
        ]
    )]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $user = null;

    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'orderRef', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $orderItems;

    /**
     * @var Collection<int, Shipping>
     */
    #[ORM\OneToMany(targetEntity: Shipping::class, mappedBy: 'orderRef', orphanRemoval: true)]
    private Collection $shippings;

    /**
     * @var Collection<int, Payment>
     */
    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'orderRef', orphanRemoval: true)]
    private Collection $payments;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
        $this->shippings = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }

    public function getPriceHT(): float
    {
        $priceHT = 0;

        foreach ($this->orderItems as $orderItem) {
            $priceHT += $orderItem->getPriceHT();
        }

        return $priceHT;
    }

    public function getPriceTTC(): float
    {
        $priceHT = 0;

        foreach ($this->orderItems as $orderItem) {
            $priceHT += $orderItem->getPriceTTC();
        }

        return $priceHT;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): static
    {
        $this->number = $number;

        return $this;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        // On boucle sur les orderItems extistants dans la commande
        foreach ($this->orderItems as $existingOrderItem) {
            // On vérifie si le nouveau orderItem est égale aux existants
            if ($existingOrderItem->equals($orderItem)) {
                // Si c'est les cas, on modifie la quantité de l'orderItem existant
                $existingOrderItem->setQuantity(
                    $existingOrderItem->getQuantity() + 1
                );

                return $this;
            }
        }

        $this->orderItems[] = $orderItem;
        $orderItem->setOrderRef($this);

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrderRef() === $this) {
                $orderItem->setOrderRef(null);
            }
        }

        return $this;
    }

    public function removeAllOrderItems(): static
    {
        foreach ($this->orderItems as $orderItem) {
            $this->removeOrderItem($orderItem);
        }

        return $this;
    }

    /**
     * @return Collection<int, Shipping>
     */
    public function getShippings(): Collection
    {
        return $this->shippings;
    }

    public function addShipping(Shipping $shipping): static
    {
        if (!$this->shippings->contains($shipping)) {
            $this->shippings->add($shipping);
            $shipping->setOrderRef($this);
        }

        return $this;
    }

    public function removeShipping(Shipping $shipping): static
    {
        if ($this->shippings->removeElement($shipping)) {
            // set the owning side to null (unless already changed)
            if ($shipping->getOrderRef() === $this) {
                $shipping->setOrderRef(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setOrderRef($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getOrderRef() === $this) {
                $payment->setOrderRef(null);
            }
        }

        return $this;
    }
}
