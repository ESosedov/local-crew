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

class SignUp extends ApiController
{
    /**
     * @OA\Response(
     *     response=200,
     *     description="Sign-up user"
     * )
     * @OA\RequestBody(@Model(type=SignUpModel::class))
     */
    #[Route(path: '/api/v1/auth/sign-up', methods: ['POST'])]
    public function signUp(#[RequestBody]SignUpModel $signUpModel, SignUpService $signUpService): Response
    {
        return $this->json($signUpService->signUp($signUpModel));

    }
}
