<?php

namespace App\Application\Exception;

class ApplicationException extends \Exception
{
    public static function fromException(\Throwable $exception, string $message = null): self
    {
        $message = $message ?: $exception->getMessage();

        return new self($message, 0, $exception);
    }
}
