<?php

namespace App\Model\Factory\User;

use App\Entity\User;
use App\Model\User\DetailModel;

class DetailModelFactory
{
    public function fromUser(User $user): DetailModel
    {
        return new DetailModel(
            $user->getName(),
            null,
            $user->getInfo(),
            $user->getCreatedAt(),
            $user->getEmail(),
            $user->getCity(),
            $user->getAge(),
            $user->getGender(),
            null,
            [],
        );
    }

}
