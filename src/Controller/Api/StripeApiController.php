<?php

namespace App\Controller\Api;

use App\Factory\StripeFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/payment/stripe', name: 'api.payment/stripe')]
class StripeApiController extends AbstractController
{
    #[Route('/notify', name: '.notify', methods: ['POST'])]
    public function notify(Request $request, StripeFactory $stripeFactory): JsonResponse
    {
        $signature = $request->headers->get('stripe-signature');

        if (!$signature) {
            throw new \InvalidArgumentException('Missing stripe signature');
        }

        return $stripeFactory->handleStripeRequest($signature, $request->getContent());
    }
}
