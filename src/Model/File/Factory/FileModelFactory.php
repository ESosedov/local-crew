<?php

namespace App\Model\File\Factory;

use App\Entity\File;
use App\Model\File\FileDTO;
use App\Model\File\FileModel;
use App\Service\File\FileService;

class FileModelFactory
{
    public function __construct(private FileService $fileService)
    {
    }

    public function fromFile(?File $file): ?FileModel
    {
        if (null === $file) {
            return null;
        }

        return new FileModel(
            $this->fileService->generateDownloadUrl($file, FileService::IMAGE_SIZE_SMALL),
            $this->fileService->generateDownloadUrl($file, FileService::IMAGE_SIZE_MEDIUM),
            $this->fileService->generateDownloadUrl($file, FileService::IMAGE_SIZE_LARGE),
        );
    }

    public function fromFileDTO(?FileDTO $fileDTO): ?FileModel
    {
        if (null === $fileDTO) {
            return null;
        }

        return new FileModel(
            $this->fileService->generateDownloadUrlFromDTO($fileDTO, FileService::IMAGE_SIZE_SMALL),
            $this->fileService->generateDownloadUrlFromDTO($fileDTO, FileService::IMAGE_SIZE_MEDIUM),
            $this->fileService->generateDownloadUrlFromDTO($fileDTO, FileService::IMAGE_SIZE_LARGE),
        );
    }
}
