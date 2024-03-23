<?php

namespace App\Controller\User\UpdateUser;

use App\Attribute\RequestBody;
use App\Controller\Api\ApiController;
use App\Controller\User\UpdateUser\Handler\Handler;
use App\Entity\User;
use App\Model\User\DetailModel;
use App\Model\User\UpdateModel;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UpdateUserController extends ApiController
{
    /**
     * @OA\RequestBody(@Model(type=UpdateModel::class))
     *
     * @OA\Response(
     *     response=200,
     *     description="User has updated",
     *
     *     @Model(type=DetailModel::class)
     *     )
     */
    #[Route(path: '/api/v1/user/update', methods: ['PUT'])]
    public function update(
        #[CurrentUser] User $user,
        #[RequestBody] UpdateModel $updateModel,
        Handler $handler
    ): JsonResponse {
        $userModelUpdated = $handler->handle($user, $updateModel);

        return $this->json($userModelUpdated);
    }
}
