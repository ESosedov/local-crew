<?php

namespace App\Controller\Dictionaries;

use App\Controller\Api\ApiController;
use App\Service\Dictionaries\DictionariesService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DictionariesController extends ApiController
{
    #[Route(path: '/api/v1/dictionaries', methods: ['GET'])]
    public function getDictionaries(DictionariesService $service): JsonResponse
    {
        return $this->json($service->getList());
    }
}
