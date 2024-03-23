<?php

namespace App\Model\User;

class ShortModel
{
    public function __construct(
        private string $id,
        private ?string $name,
        private ?string $avatar,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }
}
