<?php

namespace App\Model\User\Factory;

use App\Entity\User;
use App\Model\File\Factory\FileModelFactory;
use App\Model\User\ShortModel;

class ShortModelFactory
{
    public function __construct(private FileModelFactory $fileModelFactory)
    {
    }

    public function fromUser(User $user): ShortModel
    {
        $avatar = $this->fileModelFactory->fromFile($user->getAvatar());

        return new ShortModel(
            $user->getId(),
            $user->getName(),
            $avatar,
        );
    }

    /**
     * @param User[] $users
     *
     * @return ShortModel[]
     */
    public function fromUsers(array $users): array
    {
        $userModels = [];
        if ([] === $users) {
            return $userModels;
        }
        foreach ($users as $user) {
            $userModels[] = $this->fromUser($user);
        }

        return $userModels;
    }
}
