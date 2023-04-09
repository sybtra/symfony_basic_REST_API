<?php

namespace App\Exception;

use Exception;
use Throwable;

class AppException extends Exception
{
    private int $errorCode;

    public function __construct(string $message, int $errorCode = 0, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errorCode = $errorCode;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }
}
