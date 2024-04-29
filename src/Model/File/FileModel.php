<?php

namespace App\Model\File;

class FileModel
{
    public function __construct(
        private string $smallSize,
        private string $mediumSize,
        private string $largeSize,
    ) {
    }

    public function getSmallSize(): string
    {
        return $this->smallSize;
    }

    public function getMediumSize(): string
    {
        return $this->mediumSize;
    }

    public function getLargeSize(): string
    {
        return $this->largeSize;
    }
}
