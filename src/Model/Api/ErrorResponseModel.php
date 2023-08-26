<?php

namespace App\Model\Api;

class ErrorResponseModel
{
    public function __construct(
        private string $message,
        /**
         * @var string[]
         */
        private array $errors = [],
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
