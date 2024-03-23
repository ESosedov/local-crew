<?php

namespace App\Resolver\ArgumentResolver;

use App\Attribute\RequestFormData;
use App\Exception\RequestBodyConvertException;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestFormDataArgumentResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private PropertyAccessorInterface $propertyAccessor,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return count($argument->getAttributes(RequestFormData::class, ArgumentMetadata::IS_INSTANCEOF)) > 0;
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        try {
            $model = $this->serializer->denormalize($request->request->all(), $argument->getType(), JsonEncoder::FORMAT);
        } catch (\Throwable $throwable) {
            throw new RequestBodyConvertException($throwable);
        }
        $errors = $this->validator->validate($model);
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        /** @var RequestFormData $attribute */
        $attribute = $argument->getAttributes(RequestFormData::class, ArgumentMetadata::IS_INSTANCEOF)[0];
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get($attribute->getFileField());
        $this->propertyAccessor->setValue($model, $attribute->getFileField(), $uploadedFile);

        yield $model;
    }
}
