<?php

namespace App\Controller\User;

use App\Controller\Api\ApiController;
use App\Model\Factory\User\DetailModelFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserController extends ApiController
{
    #[Route(path: '/api/v1/user/me', methods: ['GET'])]
    public function me(#[CurrentUser] UserInterface $user, DetailModelFactory $factory): JsonResponse
    {
        return $this->json($factory->fromUser($user));
    }
}
