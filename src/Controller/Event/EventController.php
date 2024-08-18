<?php

namespace App\Controller\Event;

use App\Attribute\RequestBody;
use App\Controller\Api\ApiController;
use App\Entity\User;
use App\Form\Event\CreateForm;
use App\Model\Event\CreateEventModel;
use App\Model\Event\EventResponseModel;
use App\Model\Event\ListFilterModel;
use App\Model\Event\LocalListFilterModel;
use App\Model\Event\ResponseListModel;
use App\Service\Event\EventService;
use App\Service\Event\FavoriteEventsService;
use App\Service\EventRequestService\EventRequestService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class EventController extends ApiController
{
    /**
     * @OA\Parameter(
     *      name="json",
     *      in="query",
     *
     *      @Model(type=CreateForm::class)
     *  )
     *
     * @OA\Response(
     *      response=200,
     *      description="Returns new event",
     *
     *      @Model(type=EventResponseModel::class)
     *  )
     *
     * @OA\Tag(name="Event")
     *
     * @Security(name="Bearer")
     */
    #[Route(path: '/api/v1/event/create', methods: ['POST'])]
    public function create(
        #[CurrentUser] User $user,
        Request $request,
        EventService $eventService,
    ): JsonResponse {
        $createEventModel = new CreateEventModel();
        $form = $this->createForm(CreateForm::class, $createEventModel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->json($eventService->create($user, $createEventModel));
        }

        return $this->json($this->gatherFormErrors($form), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @OA\Parameter(
     *      name="json",
     *      in="query",
     *
     *      @Model(type=ListFilterModel::class)
     *  )
     *
     * @OA\Response(
     *      response=200,
     *      description="Returns list event",
     *
     *      @Model(type=ResponseListModel::class)
     *  )
     *
     * @OA\Tag(name="Event")
     *
     * @Security(name="Bearer")
     */
    #[Route(path: '/api/v1/event/list', methods: ['POST'])]
    public function getList(
        #[RequestBody] ListFilterModel $filterModel,
        EventService $eventService,
    ): JsonResponse {
        $user = $this->getUser();

        return $this->json($eventService->getList($filterModel, $user));
    }

    /**
     * @OA\Parameter(
     *      name="json",
     *      in="query",
     *
     *      @Model(type=LocalListFilterModel::class)
     *  )
     *
     * @OA\Response(
     *      response=200,
     *      description="Returns list local event",
     *
     *      @Model(type=ListFilterModel::class)
     *  )
     *
     * @OA\Tag(name="Event")
     *
     * @Security(name="Bearer")
     */
    #[Route(path: '/api/v1/event/local/list', methods: ['POST'])]
    public function getLocalList(
        #[RequestBody] LocalListFilterModel $filterModel,
        EventService $eventService,
    ): JsonResponse {
        $user = $this->getUser();

        return $this->json($eventService->getLocalList($filterModel, $user));
    }

    /**
     * @OA\Response(
     *      response=200,
     *      description="Success request for participation",
     *
     *      @Model(type=EventResponseModel::class)
     *  )
     *
     * @OA\Tag(name="Event")
     *
     * @Security(name="Bearer")
     */
    #[Route(path: '/api/v1/event/{id}/request/participation', requirements: ['id' => '%routing.uuid_regexp%'], methods: ['GET'])]
    public function requestParticipation(
        string $id,
        EventRequestService $eventRequestService,
    ): JsonResponse {
        $user = $this->getUser();

        return $this->json($eventRequestService->create($id, $user));
    }

    /**
     * @OA\Response(
     *      response=200,
     *      description="Returns event by id",
     *
     *      @Model(type=EventResponseModel::class)
     *  )
     *
     * @OA\Tag(name="Event")
     *
     * @Security(name="Bearer")
     */
    #[Route(path: '/api/v1/event/{id}', requirements: ['id' => '%routing.uuid_regexp%'], methods: ['GET'])]
    public function getById(
        string $id,
        EventService $eventService,
    ): JsonResponse {
        $user = $this->getUser();

        return $this->json($eventService->getById($id, $user));
    }

    /**
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *
     *     @OA\Schema(
     *         type="string"
     *     ),
     *     description="ID of Event"
     * )
     *
     * @OA\Tag(name="Event")
     *
     * @Security(name="Bearer")
     */
    #[Route(path: '/api/v1/event/{id}/add-to-favorite', requirements: ['id' => '%routing.uuid_regexp%'], methods: ['POST'])]
    public function addToFavorite(
        string $id,
        FavoriteEventsService $favoriteEventsService,
    ): JsonResponse {
        $user = $this->getUser();
        $favoriteEventsService->add($id, $user);

        return $this->emptyResponse();
    }

    /**
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *
     *     @OA\Schema(
     *         type="string"
     *     ),
     *     description="ID of Event"
     * )
     *
     * @OA\Tag(name="Event")
     *
     * @Security(name="Bearer")
     */
    #[Route(path: '/api/v1/event/{id}/remove-from-favorite', requirements: ['id' => '%routing.uuid_regexp%'], methods: ['DELETE'])]
    public function removeFromFavorite(
        string $id,
        FavoriteEventsService $favoriteEventsService,
    ): JsonResponse {
        $user = $this->getUser();
        $favoriteEventsService->remove($id, $user);

        return $this->emptyResponse();
    }
}
