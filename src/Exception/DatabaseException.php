<?php

namespace App\Exception;

class DatabaseException extends \Exception
{
    public function __construct(string $message = 'Error database request', int $code = 500, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
