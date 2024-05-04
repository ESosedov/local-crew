<?php

namespace App\Validator\Entity;


use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class EntityAccessConstraint extends Constraint
{
    public string $message = 'Entity not found';
    public string $accessErrorMessage = 'Entity can\'t be accessed';
    public string $dataClass;
    public string $permission = 'view';
    public string $repositoryMethod = 'find';

    public function __construct(
        $options = [],
        string $dataClass = null,
        string $message = null,
        string $accessErrorMessage = null,
        string $repositoryMethod = null,
        string $permission = null,
        $groups = null,
        $payload = null,
    ) {
        if (null !== $dataClass) {
            $options['value'] = $dataClass;
        }
        parent::__construct($options, $groups, $payload);
        $this->dataClass = $dataClass ?? $this->dataClass;
        $this->message = $message ?? $this->message;
        $this->accessErrorMessage = $accessErrorMessage ?? $this->accessErrorMessage;
        $this->repositoryMethod = $repositoryMethod ?? $this->repositoryMethod;
        $this->permission = $permission ?? $this->permission;
    }

    public function getDefaultOption(): string
    {
        return 'dataClass';
    }

    public function getRequiredOptions(): array
    {
        return ['dataClass'];
    }
}
