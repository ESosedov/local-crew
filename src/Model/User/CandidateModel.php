<?php

namespace App\Model\User;

class CandidateModel
{
    public function __construct(
        private UserPublicModel $user,
        private string $requestId,
    ) {
    }

    public function getUser(): UserPublicModel
    {
        return $this->user;
    }

    public function getRequestId(): string
    {
        return $this->requestId;
    }
}
