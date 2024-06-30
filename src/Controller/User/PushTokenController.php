<?php

namespace App\Controller\User;

use App\Attribute\RequestBody;
use App\Controller\Api\ApiController;
use App\Model\PushToken\UpdatePushTokenModel;
use App\Service\PushToken\PushTokenService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PushTokenController extends ApiController
{
    /**
     * @OA\Parameter(
     *      name="json",
     *      in="query",
     *
     *      @Model(type=UpdatePushTokenModel::class)
     *  )
     *
     * @OA\Response(
     *      response=200,
     *      description="Push token has been updated",
     *  )
     *
     * @OA\Tag(name="User")
     *
     * @Security(name="Bearer")
     */
    #[Route('/api/v1/user/push-token/update', methods: ['PUT'])]
    public function update(
        #[RequestBody] UpdatePushTokenModel $model,
        PushTokenService $pushTokenService,
    ): JsonResponse {
        $user = $this->getUser();
        $pushTokenService->update($user, $model);

        return $this->emptyResponse();
    }

    /**
     * @OA\Response(
     *      response=200,
     *      description="Push token has been deleted",
     *  )
     *
     * @OA\Tag(name="User")
     *
     * @Security(name="Bearer")
     */
    #[Route('/api/v1/user/push-token/delete', methods: ['DELETE'])]
    public function delete(PushTokenService $pushTokenService): JsonResponse
    {
        $user = $this->getUser();
        $pushTokenService->delete($user);

        return $this->emptyResponse();
    }
}
