<?php

namespace App\Model\File;

class FileDTO
{
    public function __construct(
        private string $id,
        private string $externalId,
        private string $extension,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }
}
