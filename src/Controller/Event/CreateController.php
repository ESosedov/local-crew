<?php

namespace App\Controller\Event;

use App\Attribute\RequestFormData;
use App\Controller\Api\ApiController;
use App\Entity\User;
use App\Model\Event\CreateEventModel;
use App\Service\Event\EventService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class CreateController extends ApiController
{
    #[Route(path: '/api/v1/event/create', methods: ['POST'])]
    public function create(
        #[CurrentUser] User $user,
        #[RequestFormData(fileField: 'avatar')] CreateEventModel $createEventModel,
        EventService $eventService,
    ): JsonResponse {
        return $this->json($eventService->create($user, $createEventModel));
    }
}
