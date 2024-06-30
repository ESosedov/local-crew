<?php

namespace App\Model\User;

use App\Model\File\FileModel;

class ShortModel
{
    public function __construct(
        private string $id,
        private string|null $name,
        private FileModel|null $avatar,
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

    public function getAvatar(): ?FileModel
    {
        return $this->avatar;
    }
}
