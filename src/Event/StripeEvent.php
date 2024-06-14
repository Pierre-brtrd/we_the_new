<?php

namespace App\Event;

use Stripe\ApiResource;
use Stripe\Event;
use Symfony\Contracts\EventDispatcher\Event as BaseEvent;

class StripeEvent extends BaseEvent
{
    public function __construct(
        private Event $stripeEvent,
    ) {
    }

    public function getName(): string
    {
        return $this->stripeEvent->type;
    }

    public function getRessource(): ApiResource
    {
        return $this->stripeEvent->data->object;
    }
}
