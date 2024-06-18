<?php

namespace App\EventListener;

use App\Entity\Order\Order;
use App\Entity\Order\Payment;
use App\Event\StripeEvent;
use App\Repository\Order\OrderRepository;
use App\Repository\Order\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: 'payment_intent.succeeded', method: 'onPaymentSucceed')]
class StripeEventListener
{   
    public function __construct(
        private EntityManagerInterface $em,
        private OrderRepository $orderRepository,
        private PaymentRepository $paymentRepository,

    ){}
    public function onPaymentSucceed(StripeEvent $event): void
    {
        $resource = $event->getResource();

        if (!$resource) {
            throw new \InvalidArgumentException('The event resource is missing');
        }
        
        $payment = $this->paymentRepository->find($resource->metadata->payment_id);
        $order = $this->orderRepository->find($resource->metadata->order_id);

        if (!$payment || !$order) {
            throw new \InvalidArgumentException('The payment or order is missing');
        }

        // mettre a jour la bdd

        $payment->setStatus(Payment::STATUS_PAID);
        $order->setStatus(Order::STATUS_SHIPPING);

        $this->em->persist($payment);
        $this->em->persist($order);
        $this->em->flush();
    }
}
