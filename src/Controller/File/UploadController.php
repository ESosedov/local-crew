<?php

namespace App\Controller\File;

use App\Attribute\RequestFile;
use App\Controller\Api\ApiController;
use App\Service\File\FileService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends ApiController
{
    #[Route(path: '/api/v1/file/upload', methods: ['POST'])]
    public function upload(
        #[RequestFile(field: 'file', constraints: [])]
        UploadedFile $uploadedFile,
        FileService $fileService
    ): JsonResponse {
        return $this->json($fileService->uploadFile($uploadedFile)->getUrl());
    }
}
