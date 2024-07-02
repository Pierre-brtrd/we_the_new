<?php

namespace App\EventListener;

use App\Entity\Order\Order;
use App\Entity\Order\Payment;
use App\Event\StripeEvent;
use App\Repository\Order\OrderRepository;
use App\Repository\Order\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: 'payment_intent.succeeded', method: 'onPaymentSucceed')]
#[AsEventListener(event: 'payment_intent.payment_failed', method: 'onPaymentFailed')]
class StripeEventListener
{
    public function __construct(
        private EntityManagerInterface $em,
        private OrderRepository $orderRepository,
        private PaymentRepository $paymentRepository,
        private LoggerInterface $logger,
    ) {
    }

    public function onPaymentSucceed(StripeEvent $event): void
    {
        // On récupère la ressource de l'événement
        $resource = $event->getResource();

        // On vérifie que la ressource est bien une charge Stripe
        if (!$resource) {
            throw new \InvalidArgumentException('The event resource is missing.');
        }

        // On récupère le payment associé en BDD
        $payment = $this->paymentRepository->find($resource->metadata->payment_id);
        // On récupère la commande associée en BDD
        $order = $this->orderRepository->find($resource->metadata->order_id);

        // On vérifie que le paiement et la commande existent
        if (!$payment || !$order) {
            throw new \InvalidArgumentException('The payment or order is missing.');
        }

        // On met à jour le paiement et la commande
        $payment->setStatus(Payment::STATUS_PAID);
        $order->setStatus(Order::STATUS_SHIPPING);
        $order->setNumber('ORD-' . $order->getId() . '-' . date('YmdHis'));

        $this->em->persist($payment);
        $this->em->persist($order);

        $this->em->flush();
    }

    public function onPaymentFailed(StripeEvent $event): void
    {
        $resource = $event->getResource();

        if (!$resource) {
            throw new \InvalidArgumentException('The event resource is missing.');
        }

        $payment = $this->paymentRepository->find($resource->metadata->payment_id);
        $order = $this->orderRepository->find($resource->metadata->order_id);

        if (!$payment || !$order) {
            throw new \InvalidArgumentException('The payment or order is missing.');
        }

        $order->setStatus(Order::STATUS_AWAITING_PAYMENT);
        $payment->setStatus(Payment::STATUS_FAILED);

        $this->em->persist($payment);
        $this->em->persist($order);

        $this->em->flush();
    }
}
