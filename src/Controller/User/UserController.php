<?php

namespace App\Controller\User;

use App\Attribute\RequestBody;
use App\Controller\Api\ApiController;
use App\Model\User\SignUpModel;
use App\Service\User\SignUpService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserController extends ApiController
{
    #[Route(path: '/api/v1/user/me', methods: ['GET'])]
    public function me(#[CurrentUser] UserInterface $user): Response
    {
        return $this->json($user);

    }
}
