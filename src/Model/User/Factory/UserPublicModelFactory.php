<?php

namespace App\Model\User\Factory;

use App\Entity\User;
use App\Model\File\Factory\FileModelFactory;
use App\Model\User\UserPublicModel;

class UserPublicModelFactory
{
    public function __construct(private FileModelFactory $fileModelFactory)
    {
    }

    public function fromUser(User $user): UserPublicModel
    {
        $avatar = $this->fileModelFactory->fromFile($user->getAvatar());

        return new UserPublicModel(
            $user->getId(),
            $user->getName(),
            $avatar,
            $user->getInfo(),
            $user->getCreatedAt(),
            $user->getBirthDate(),
            $user->getGender(),
        );
    }

    public function fromUsers(array $users): array
    {
        $result = [];
        foreach ($users as $user) {
            $result[] = $this->fromUser($user);
        }

        return $result;
    }
}
