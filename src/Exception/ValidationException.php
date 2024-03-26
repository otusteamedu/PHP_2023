<?php
declare(strict_types=1);

namespace App\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends Exception
{
    public function __construct(
        private readonly ConstraintViolationListInterface $violationList,
    ) {
        parent::__construct('Validation error.');
    }

    public function getErrors(): array
    {
        $errorList = [];

        foreach ($this->violationList as $propertyName => $violation) {
            $errorList[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $errorList;
    }
}
