<?php

namespace App\Controller\EventRequest;

use App\Controller\Api\ApiController;
use App\Entity\Event;
use App\Security\Voter\EventVoter;
use App\Service\EventRequestService\EventRequestService;
use App\Validator\Entity\EntityAccessConstraint;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventRequestController extends ApiController
{
    /**
     * @OA\Response(
     *      response=200,
     *      description="Request participation approved",
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
        $eventRequestService->approve($id);

        return $this->emptyResponse(Response::HTTP_OK);
    }

    /**
     * @OA\Response(
     *      response=200,
     *      description="Request participation rejected",
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
        $eventRequestService->reject($id);

        return $this->emptyResponse(Response::HTTP_OK);
    }
}
