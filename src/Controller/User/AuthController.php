<?php

namespace App\Controller\User;

use App\Attribute\RequestBody;
use App\Controller\Api\ApiController;
use App\Model\User\SignUpModel;
use App\Service\User\SignUpService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\Api\ErrorResponse;

class AuthController extends ApiController
{
    /**
     * @OA\Response(
     *     response=200,
     *     description="Sign-up user",
     *     @OA\JsonContent(
     *         @OA\Property(property="token", type="string"),
     *         @OA\Property(property="refresh_token", type="string")
     *     )
     * )
     * @OA\Response(
     *     response=409,
     *     description="User already exists",
     *     @Model( type=ErrorResponse::class)
     * )
     * @OA\Response(
     *      response=400,
     *      description="Validation failed",
     *      @Model( type=ErrorResponse::class)
     *  )
     * @OA\RequestBody(@Model(type=SignUpModel::class))
     */
    #[Route(path: '/api/v1/auth/sign-up', methods: ['POST'])]
    public function signUp(#[RequestBody]SignUpModel $signUpModel, SignUpService $signUpService): Response
    {
        return $signUpService->signUp($signUpModel);
    }
}
