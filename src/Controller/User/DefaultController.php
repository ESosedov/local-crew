<?php

namespace App\Controller\User;

use App\Controller\Api\ApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class DefaultController extends ApiController
{
    #[Route(path: '/', methods: ['GET'])]
    public function me(): Response
    {
        return $this->json('Danya pidor!');
    }
}
