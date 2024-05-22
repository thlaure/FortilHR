<?php

namespace App\Service;

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
            $this->logger->error('Extension not allowed: ' . $extension);

            return false;
        }

        return true;
    }

    public function isMimeTypeValid(string $fileName, array $allowedMimeTypes): bool
    {
        $mimeType = mime_content_type($fileName);
        if (!in_array($mimeType, $allowedMimeTypes)) {
            $this->logger->error('Mime type not allowed: ' . $mimeType);

            return false;
        }

        return true;
    }

    public function isSizeValid(UploadedFile $file, int $maxFileSize): bool
    {
        if ($file->getSize() > $maxFileSize) {
            $this->logger->error('File too large: ' . $file->getSize());

            return false;
        }

        return true;
    }
}
