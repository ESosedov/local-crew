<?php

namespace App\Model\User\Factory;

use App\Entity\User;
use App\Model\User\ShortModel;

class ShortModelFactory
{
    public function fromUser(User $user): ShortModel
    {
        return new ShortModel(
            $user->getId(),
            $user->getName(),
            $user->getAvatar()?->getUrl(),
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
