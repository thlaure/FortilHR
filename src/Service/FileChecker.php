<?php

namespace App\Service;

use App\Constant\Constraint;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileChecker
{
    public function __construct(
        private string $targetDirectory,
        private LoggerInterface $logger
    ) {
    }

    public function checkExtensionIsAllowed(string $fileName, array $allowedExtensions): bool
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        if (!in_array($extension, $allowedExtensions)) {
            $this->logger->error('Extension not allowed: ' . $extension);

            return false;
        }

        return true;
    }

    public function checkMimeTypeIsAllowed(string $fileName, array $allowedMimeTypes): bool
    {
        $mimeType = mime_content_type($fileName);
        if (!in_array($mimeType, $allowedMimeTypes)) {
            $this->logger->error('Mime type not allowed: ' . $mimeType);

            return false;
        }

        return true;
    }

    public function checkFileExtensionIsForbidden(string $fileName, array $forbiddenFileExtensions): bool
    {
        $fileElements = explode('.', $fileName);

        foreach ($fileElements as $fileElement) {
            if (in_array($fileElement, $forbiddenFileExtensions) || preg_match($fileElement, Constraint::REGEX_PHP_EXTENSION)) {
                $this->logger->error('Forbidden extension: ' . $fileElement);

                return false;
            }
        }

        return true;
    }

    public function checkImageSize(UploadedFile $file): bool
    {
        if ($file->getSize() > Constraint::IMAGE_MAX_FILE_SIZE) {
            $this->logger->error('File too large: ' . $file->getSize());

            return false;
        }

        return true;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}
