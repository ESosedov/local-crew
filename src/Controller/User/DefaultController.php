<?php

namespace App\Controller\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class DefaultController
{
    #[Route(path: '/', methods: ['GET'])]
    public function me():void
    {
        dump('Danya pidor!');
    }
}
