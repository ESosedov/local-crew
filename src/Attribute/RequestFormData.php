<?php

namespace App\Attribute;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PARAMETER)]
class RequestFormData
{
    /**
     * @param Constraint[] $constraints
     */
    public function __construct(private string $fileField, private array $constraints = [])
    {
    }

    public function getFileField(): string
    {
        return $this->fileField;
    }

    /**
     * @return Constraint[]
     */
    public function getConstraints(): array
    {
        return $this->constraints;
    }
}
