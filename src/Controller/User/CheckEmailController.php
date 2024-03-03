<?php

namespace App\Controller\User;

use App\Attribute\RequestBody;
use App\Controller\Api\ApiController;
use App\Model\User\EmailModel;
use App\Model\User\UpdateModel;
use App\Service\User\CheckEmailService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CheckEmailController extends ApiController
{
    /**
     * @OA\RequestBody(@Model(type=UpdateModel::class))
     *
     * @OA\Response(
     *     response=200,
     *     description="Email is available",
     *     )
     *
     * @Security(name="Bearer")
     */
    #[Route(path: '/api/v1/email/check', methods: ['POST'])]
    public function update(
        #[RequestBody] EmailModel $emailModel,
        CheckEmailService $checkEmailService,
    ): JsonResponse {
        $checkEmailService->check($emailModel);

        return $this->emptyResponse();
    }
}
