<?php

namespace App\Service\File;

use App\Entity\File;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use RuntimeException;

class CloudinaryStorage implements FileStorageInterface
{
    private const WIDTH_SMALL = 250;
    private const WIDTH_MEDIUM = 500;
    private const WIDTH_LARGE = 1000;

    private UploadApi $uploadApi;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
    ) {
        $this->uploadApi = new UploadApi(new Configuration($_ENV['CLOUDINARY_URL']));
    }

    public function put(string $filePath): File
    {
        try {
            $uploaded = $this->uploadApi->upload($filePath);
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
            throw new RuntimeException('Upload file error.');
        }
        unlink($filePath);

        $fileEntity = new File();
        $fileEntity
            ->setExternalId($uploaded['public_id'])
            ->setUrl($uploaded['secure_url'])
            ->setExtension($uploaded['format']);

        $this->entityManager->persist($fileEntity);
        $this->entityManager->flush();

        return $fileEntity;
    }

    public function remove(File $file): void
    {
        $this->uploadApi->destroy($file->getExternalId());

        $this->entityManager->remove($file);
        $this->entityManager->flush();
    }

    public function generateDownloadUrl(File $file, string $size): string
    {
        $width = match ($size) {
            FileService::IMAGE_SIZE_SMALL => self::WIDTH_SMALL,
            FileService::IMAGE_SIZE_MEDIUM => self::WIDTH_MEDIUM,
            FileService::IMAGE_SIZE_LARGE => self::WIDTH_LARGE,
        };

        return sprintf(
            'https://res.cloudinary.com/dmmtj67jc/image/upload/w_%d/q_auto:best/%s.%s',
            $width,
            $file->getExternalId(),
            $file->getExtension());
    }
}
