<?php

namespace App\Model\User;

class IdResponse
{
    public function __construct(private string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
