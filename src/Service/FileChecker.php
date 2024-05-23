<?php

namespace App\Service;

use App\Constant\Constraint;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileChecker
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function isExtensionValid(string $fileName, array $allowedExtensions): bool
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        if (!in_array($extension, $allowedExtensions)) {
            $this->logger->error('Extension not allowed: '.$extension);

            return false;
        }

        return true;
    }

    public function isMimeTypeValid(string $fileName, array $allowedMimeTypes): bool
    {
        $mimeType = mime_content_type($fileName);
        if (!in_array($mimeType, $allowedMimeTypes)) {
            $this->logger->error('Mime type not allowed: '.$mimeType);

            return false;
        }

        return true;
    }

    public function isSizeValid(UploadedFile $file, int $maxFileSize): bool
    {
        if ($file->getSize() > $maxFileSize) {
            $this->logger->error('File too large: '.$file->getSize());

            return false;
        }

        return true;
    }

    public function isMimeTypeCorrespondingToExtension(UploadedFile $file, array $allowedMimeTypesByExtension): bool
    {
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $allowedMimeTypesByExtension[$extension])) {
            $this->logger->error('Mime type and extension not matching: '.$mimeType);

            return false;
        }

        return true;
    }

    public function checkImageIsValid(UploadedFile $file): bool
    {
        $fileName = $file->getClientOriginalName();
        $extensionIsValid = $this->isExtensionValid($fileName, Constraint::IMAGE_ALLOWED_EXTENSIONS);
        $mimeTypeIsValid = $this->isMimeTypeValid($fileName, Constraint::IMAGE_ALLOWED_MIME_TYPES);
        $sizeIsValid = $this->isSizeValid($file, Constraint::IMAGE_MAX_FILE_SIZE);
        $mimeTypeCorrespondToExtension = $this->isMimeTypeCorrespondingToExtension($file, Constraint::IMAGE_ALLOWED_MIME_TYPE_BY_EXTENSION);

        if (!$extensionIsValid || !$mimeTypeIsValid || !$sizeIsValid || !$mimeTypeCorrespondToExtension) {
            return false;
        }

        return true;
    }
}
