<?php

namespace App\Model\User\Factory;

use App\Entity\User;
use App\Model\User\UserPublicModel;

class UserPublicModelFactory
{
    public function fromUser(User $user): UserPublicModel
    {
        return new UserPublicModel(
            $user->getId(),
            $user->getName(),
            $user->getAvatar()?->getUrl(),
            $user->getInfo(),
            $user->getCreatedAt(),
            $user->getAge(),
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
