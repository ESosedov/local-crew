<?php

namespace App\Validator\Entity;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class EntityConstraint extends Constraint
{
    public string $message = 'Entity not found';
    public string $dataClass;

    public function getDefaultOption(): string
    {
        return 'dataClass';
    }

    public function getRequiredOptions(): array
    {
        return ['dataClass'];
    }
}
