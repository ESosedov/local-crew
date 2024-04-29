<?php

namespace App\Service\File;

use App\Entity\File;

interface FileStorageInterface
{
    public function put(string $filePath): File;
}
