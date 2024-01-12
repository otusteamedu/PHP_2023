<?php

namespace Gesparo\Homework\Application;

use Gesparo\Homework\AppException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

trait ViolationsExceptionTrait
{
    /**
     * @throws AppException
     */
    private function throwViolationsException(ConstraintViolationListInterface $violations): void
    {
        throw AppException::validationError(array_map(
            static fn($violation) => [
                'property' => $violation->getPropertyPath(),
                'message' => $violation->getMessage()
            ],
            iterator_to_array($violations)
        ));
    }
}
