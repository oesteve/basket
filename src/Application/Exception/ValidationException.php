<?php

namespace App\Application\Exception;

class ValidationException extends ApplicationException
{
    /**
     * @var ValidationFieldException[]
     */
    private $fieldExceptions;

    public function addFieldException(ValidationFieldException $fieldException): void
    {
        $this->fieldExceptions[] = $fieldException;
    }

    /**
     * @return ValidationFieldException[]
     */
    public function getFieldExceptions(): array
    {
        return $this->fieldExceptions;
    }
}
