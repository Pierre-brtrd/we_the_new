<?php

namespace App\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\ClickableInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ClearCartListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SUBMIT => 'onPostSubmit',
        ];
    }

    public function onPostSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $cart = $event->getData();

        if (!$cart) {
            return;
        }

        /** @var ClickableInterface $clearBtn */
        $clearBtn = $form->get('clear');

        if ($clearBtn->isClicked()) {
            $cart->removeAllOrderItems();
        }
    }
}
