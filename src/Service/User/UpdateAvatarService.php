<?php

namespace App\Service\User;

use App\Entity\User;
use App\Service\File\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateAvatarService
{
    public function __construct(
        private FileService $fileService,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function update(User $user, UploadedFile $avatar): void
    {
        $oldAvatar = $user->getAvatar();

        $file = $this->fileService->uploadFile($avatar);

        $user->setAvatar($file);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        if (null !== $oldAvatar) {
            $this->fileService->removeFile($oldAvatar);
        }
    }
}
