<?php

namespace App\Controller\EventRequest;

use App\Controller\Api\ApiController;
use App\Entity\Event;
use App\Model\Event\EventResponseModel;
use App\Security\Voter\EventVoter;
use App\Service\EventRequestService\EventRequestService;
use App\Validator\Entity\EntityAccessConstraint;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EventRequestController extends ApiController
{
    /**
     * @OA\Response(
     *      response=200,
     *      description="Request participation approved",
     *
     *      @Model(type=EventResponseModel::class)
     *  )
     *
     * @OA\Tag(name="EventRequest")
     *
     * @Security(name="Bearer")
     */
    #[Route('/api/v1/event-request/{id}/approve', requirements: ['id' => '%routing.uuid_regexp%'], methods: ['GET'])]
    public function approveRequest(
        #[EntityAccessConstraint(
            dataClass: Event::class,
            permission: EventVoter::PERMISSION_ORGANIZER,
        )]
        string $id,
        EventRequestService $eventRequestService,
    ): JsonResponse {
        $user = $this->getUser();

        return $this->json($eventRequestService->approve($id, $user));
    }

    /**
     * @OA\Response(
     *      response=200,
     *      description="Request participation rejected",
     *
     *      @Model(type=EventResponseModel::class)
     *  )
     *
     * @OA\Tag(name="EventRequest")
     *
     * @Security(name="Bearer")
     */
    #[Route('/api/v1/event-request/{id}/reject', requirements: ['id' => '%routing.uuid_regexp%'], methods: ['GET'])]
    public function reject(
        #[EntityAccessConstraint(
            dataClass: Event::class,
            permission: EventVoter::PERMISSION_ORGANIZER,
        )]
        string $id,
        EventRequestService $eventRequestService,
    ): JsonResponse {
        $user = $this->getUser();

        return $this->json($eventRequestService->reject($id, $user));
    }
}
