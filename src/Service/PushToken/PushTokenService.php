<?php

namespace App\Service\PushToken;

use App\Entity\PushToken;
use App\Entity\User;
use App\Model\PushToken\UpdatePushTokenModel;
use App\Repository\PushTokenRepository;

class PushTokenService
{
    public function __construct(private PushTokenRepository $pushTokenRepository)
    {
    }

    public function update(User $user, UpdatePushTokenModel $model): void
    {
        $token = $this->pushTokenRepository->findOneBy(['user' => $user]);

        if (null === $token) {
            $token = new PushToken();
            $token->setUser($user);
        }

        $token->setToken($model->getToken());

        $this->pushTokenRepository->save($token, true);
    }

    public function get(User|string $user): string
    {
        return $this->pushTokenRepository->findOneBy(['user' => $user])?->getToken();
    }

    public function delete(User $user): void
    {
        $this->pushTokenRepository->removeByUser($user);
    }
}
