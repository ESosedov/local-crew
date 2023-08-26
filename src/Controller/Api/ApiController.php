<?php

namespace App\Controller\Api;

use App\Model\ErrorResponseModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    protected function gatherFormErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true) as $formError) {
            $path = $formError->getOrigin()->getName();
            $form = $formError->getOrigin();
            if (!$path && $form->isRoot()) {
                $errors[] = [
                    'propertyName' => null,
                    'message' => $formError->getMessage(),
                ];
            } else {
                while ($form->getParent() && !$form->getParent()->isRoot()) {
                    $form = $form->getParent();
                    $path = sprintf('%s.%s', $form->getName(), $path);
                }
                $errors[] = [
                    'propertyName' => $path,
                    'message' => $formError->getMessage(),
                ];
            }
        }

        return [
            'message' => 'Error validation request',
            'errors' => $errors,
        ];
    }

    protected function emptyResponse(int $status = Response::HTTP_OK, array $headers = []): JsonResponse
    {
        return new JsonResponse(null, $status, $headers);
    }

    protected function apiErrorResponse(string $message, int $status, $errors = []): JsonResponse
    {
        return $this->json(new ErrorResponseModel($message, $errors), $status);
    }
}
