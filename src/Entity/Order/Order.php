<?php

namespace App\Entity\Order;

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
    public const STATUS_AWAITING_PAYMENT = "awaiting_payment";
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
            self::STATUS_CANCELED,
        ]
    )]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $user = null;

    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'orderRef', cascade: ['persist', 'remove'], orphanRemoval:true)]
    private Collection $orderItems;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    public function getPriceHT(): float {
        $priceHT = 0;
        foreach($this->orderItems as $orderItem) {
            $priceHT += $orderItem->getPriceHT();
        }   
        return $priceHT;
    }

    public function getPriceTTC(): float {
        $priceTTC = 0;
        foreach($this->orderItems as $orderItem) {
            $priceTTC += $orderItem->getPriceTTC();
        }   
        return $priceTTC;
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
        //on boucle sur les OrderItem existants dans la commande
        foreach($this->orderItems as $existingOrderItem) {
            //on vérifie si le nouveau orderItem est égal aux existants
            if($existingOrderItem->equals($orderItem)) {
                //si c'est le cas, on modifie la quantité de l'orderItem existant
                $existingOrderItem->setQuantity($existingOrderItem->getQuantity() + 1);

                return $this;
            }
        }
        $this->orderItems[] = $orderItem;
        $orderItem->setOrderRef($this);

        return $this;
    }

    /**
     * Remove one item from cart
     *
     * @param OrderItem $orderItem
     * @return static
     */
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

    /**
     * remove all items from cart
     *
     * @return static
     */
    public function removeAllOrderItems(): static {
        foreach($this->orderItems as $orderItem) {
            $this->removeOrderItem($orderItem);
        }

        return $this;
    }
}
