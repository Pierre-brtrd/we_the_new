<?php 

namespace App\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\ClickableInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RemoveItemCartListener implements EventSubscriberInterface {
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SUBMIT => 'onPostSubmit',
        ];       
    }

    public function onPostSubmit(FormEvent $event): void {
        $form = $event->getForm();
        $cart = $event->getData();

        foreach($form->get('orderItems')->all() as $child) {
            /** @var ClickableInterface $removeBtn */
            $removeBtn = $child->get('remove');

            if($removeBtn->isClicked()) {
                $cart->removeOrderItem($child->getData());

                return;
            }
        }
    }
}