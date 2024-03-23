<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \RuntimeException
{
    public function __construct(private ConstraintViolationListInterface $violation)
    {
        parent::__construct('validation failed');
    }

    public function getViolation(): ConstraintViolationListInterface
    {
        return $this->violation;
    }
}
