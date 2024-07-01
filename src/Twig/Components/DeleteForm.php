<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class DeleteForm
{
    private string $action;
    private string $csrftoken;
    private string $message;
}
