<?php

namespace App\Model\File;

class FileResponseModel
{
    public function __construct(private string $url)
    {
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
