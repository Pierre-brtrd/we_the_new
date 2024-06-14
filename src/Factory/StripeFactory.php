<?php

namespace App\Factory;

use Stripe\Event;
use Stripe\Stripe;
use Stripe\Webhook;
use App\Event\StripeEvent;
use App\Entity\Order\Order;
use Stripe\Checkout\Session;
use Webmozart\Assert\Assert;
use App\Entity\Order\OrderItem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Stripe\Exception\SignatureVerificationException;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class StripeFactory
{
    public function __construct(
        private string $stripeSecretKey,
        private string $webhookSecret,
        private EventDispatcherInterface $eventDispatcher,
    ) {
        Stripe::setApiKey($stripeSecretKey);
        Stripe::setApiVersion('2024-04-10');
    }


    public function createSession(Order $order, string $successUrl, string $cancelUrl): Session
    {
        Assert::notEmpty($order->getPayments(), 'You must have at least one payment to create a Stripe session');

        return Session::create([
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'customer_email' => $order->getUser()->getEmail(),
            'line_items' => array_map(function (OrderItem $orderItem): array {
                return [
                    'quantity' => $orderItem->getQuantity(),
                    'price_data' => [
                        'currency' => 'EUR',
                        'product_data' => [
                            'name' => $orderItem->getQuantity() . 'x' . $orderItem->getProductVariant()->getProduct()->getName(),
                        ],
                        'unit_amount' => bcmul($orderItem->getPriceTTC() / $orderItem->getQuantity(), 100),
                    ],
                ];
            }, $order->getOrderItems()->toArray()),
            'shipping_options' => [
                [
                    'shipping_rate_data' => [
                        'type' => 'fixed_amount',
                        'fixed_amount' => [
                            'currency' => 'EUR',
                            'amount' => $order->getShippings()->last()->getDelivery()->getPrice() * 100,
                        ],
                        'display_name' => $order->getShippings()->last()->getDelivery()->getName(),
                    ]
                ],
            ],
            'metadata' => [
                'order_id' => $order->getId(),
                'payment_id' => $order->getPayments()->last()->getId(),
            ],
            'payment_intent_data' => [
                'metadata' => [
                    'order_id' => $order->getId(),
                    'payment_id' => $order->getPayments()->last()->getId(),
                ],
            ]

        ]);
    }

    /**
     * Permet d'analyser la requête stripe et de retourner l'événement correspondant
     *
     * @param string $signature, la signature stripe de la requête
     * @param mixed $body, le contenu de la requête
     * @return Event|JsonResponse
     */
    public function handleStripeRequest(string $signature, mixed $body): JsonResponse
    {
        if (!$body) {
            return new JsonResponse([
                'status' => 'error',
                'messages' => 'missing body content',
            ], 404);
        }

        if (!$signature) {
            return new JsonResponse([
                'status' => 'error',
                'messages' => 'missing signature content',
            ], 407);
        }

        $event = $this->getEvent($signature, $body);

        //Si event est de la class jsonresponse, on retourne directement la réponse (erreur)
        if ($event instanceof JsonResponse) {
            return $event;
        }

        $event = new StripeEvent($event);

        $this->eventDispatcher->dispatch($event, $event->getName());
        

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Event receive dand processed successfully'
        ]);
    }
    /**
     * Permet de décoder la requête stripe et de retourner l'éveneemnt correspondant
     *
     * @param string $signature , la signature $stripe de la requête
     * @param mixed $body le contenu de la requête
     * @return Event|JsonResponse l'évènement stripe ou une réponse JSOn d'erreur
     */
    private function getEvent(string $signature, mixed $body): Event|JsonResponse
    {
        try {
            $event = Webhook::constructEvent($body, $signature, $this->webhookSecret);
        } catch (\UnexpectedValueException $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 405);
        } catch (SignatureVerificationException $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 404);
        }

        return $event;
    }
}
