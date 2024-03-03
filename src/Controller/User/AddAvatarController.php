<?php

namespace App\Controller\User;

use App\Attribute\RequestFile;
use App\Controller\Api\ApiController;
use App\Model\Factory\User\DetailModelFactory;
use App\Service\User\UpdateAvatarService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AddAvatarController extends ApiController
{
    #[Route(path: '/api/v1/user/add-avatar', methods: ['POST'])]
    public function upload(
        #[CurrentUser] UserInterface $user,
        #[RequestFile(field: 'file', constraints: [])]
        UploadedFile $uploadedFile,
        UpdateAvatarService $updateAvatarService,
        DetailModelFactory $factory,
    ): JsonResponse {
        $updateAvatarService->update($user, $uploadedFile);

        return $this->json($factory->fromUser($user));
    }
}
