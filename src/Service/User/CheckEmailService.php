<?php

namespace App\Service\User;

use App\Exception\User\UserAlreadyExistsException;
use App\Model\User\EmailModel;
use App\Repository\UserRepository;

class CheckEmailService
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function check(EmailModel $emailModel): void
    {
        if (null !== $this->userRepository->getByEmail($emailModel->getEmail())) {
            throw new UserAlreadyExistsException();
        }
    }
}
