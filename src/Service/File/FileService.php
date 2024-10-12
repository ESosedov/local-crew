<?php

namespace App\Service\File;

use App\Entity\File;
use App\Model\File\FileDTO;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    public const IMAGE_SIZE_SMALL = 'small';
    public const IMAGE_SIZE_MEDIUM = 'medium';
    public const IMAGE_SIZE_LARGE = 'large';

    public function __construct(
        private string $uploadDir,
        private FileStorageInterface $storage,
    ) {
    }

    public function uploadFile(UploadedFile $file): File
    {
        $extension = $file->guessExtension();
        if (null === $extension) {
            throw new \RuntimeException();
        }

        $uniqueName = Uuid::uuid4()->toString().'.'.$extension;
        $uploadPath = $this->uploadDir.DIRECTORY_SEPARATOR.'foto';
        $fullPath = $uploadPath.DIRECTORY_SEPARATOR.$uniqueName;
        $file->move($uploadPath, $uniqueName);

        return $this->storage->put($fullPath);
    }

    public function removeFile(File $file): void
    {
        $this->storage->remove($file);
    }

    public function generateDownloadUrl(File $file, string $size): string
    {
        return $this->storage->generateDownloadUrl($file, $size);
    }

    public function generateDownloadUrlFromDTO(FileDTO $fileDTO, string $size): string
    {
        return $this->storage->generateDownloadUrlFromDTO($fileDTO, $size);
    }
}
