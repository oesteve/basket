<?php

namespace App\Application\Exception;

class ValidationFieldException extends ApplicationException
{
    /** @var string */
    private $field;

    public static function create(string $field, string $message): self
    {
        $exception = new self($message);
        $exception->setField($field);

        return $exception;
    }

    private function setField(string $field): void
    {
        $this->field = $field;
    }

    public function getField(): string
    {
        return $this->field;
    }
}
