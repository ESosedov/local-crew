<?php

namespace App\Controller\Notification;

use App\Controller\Api\ApiController;
use App\Model\Notification\SentMessageListModel;
use App\Service\Notification\SentMessageService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends ApiController
{
    /**
     * @OA\Response(
     *      response=200,
     *      description="Returns all notifications",
     *
     *      @Model(type=SentMessageListModel::class)
     *  )
     *
     * @OA\Tag(name="Notification")
     *
     * @Security(name="Bearer")
     */
    #[Route(path: '/api/v1/notification/push/all', methods: ['GET'])]
    public function getAll(SentMessageService $sentMessageService): JsonResponse
    {
        $user = $this->getUser();

        return $this->json($sentMessageService->getPushAll($user));
    }
}
