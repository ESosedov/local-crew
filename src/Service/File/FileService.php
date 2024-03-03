<?php

namespace App\Service\File;

use App\Entity\File;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    public function __construct(
        private string $uploadDir,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function uploadFile(UploadedFile $file): File
    {
        $extention = $file->guessExtension();
        if (null === $extention) {
            throw new \Exception();
        }

        $uniqueName = Uuid::uuid4()->toString().'.'.$extention;
        $uploadPath = $this->uploadDir.DIRECTORY_SEPARATOR.'foto';
        $fullPath = $uploadPath.DIRECTORY_SEPARATOR.$uniqueName;

        $file->move($uploadPath, $uniqueName);

        $api = new UploadApi(new Configuration($_ENV['CLOUDINARY_URL']));
        $uploaded = $api->upload($fullPath);
        unlink($fullPath);

        $fileEntity = new File();
        $fileEntity
            ->setExternalId($uploaded['public_id'])
            ->setUrl($uploaded['secure_url']);

        $this->entityManager->persist($fileEntity);
        $this->entityManager->flush();

        return $fileEntity;
    }

    public function removeFile(File $file): void
    {
        $api = new UploadApi(new Configuration($_ENV['CLOUDINARY_URL']));
        $api->destroy($file->getExternalId());

        $this->entityManager->remove($file);
        $this->entityManager->flush();
    }
}
