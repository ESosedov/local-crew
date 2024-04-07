<?php

namespace App\Model\PushToken;

use Symfony\Component\Validator\Constraints as Assert;

class UpdatePushTokenModel
{
    public function __construct(
        #[Assert\NotNull()]
        private string $token,
    ) {
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
