<?php

namespace App\Controller\Api\Traits;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

trait ApiControllerTrait
{
    private function getFormErrors(FormInterface $form): JsonResponse
    {
        $errors = [];

        foreach ($form->getErrors(true) as $error) {
            $formField = $error->getOrigin();
            $errors[$formField->getName()] = [
                'message' => $error->getMessage(),
            ];
        }

        return $this->json($errors, 422);
    }
}
