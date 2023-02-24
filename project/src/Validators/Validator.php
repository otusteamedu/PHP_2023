<?php
declare(strict_types=1);

namespace Vp\App\Validators;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    private bool $isValid = true;
    private array $errors = [];
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate($constraints, $data): Validator
    {
        $violations = $this->validator->validate(
            $data,
            $constraints
        );

        if (count($violations) < 1) {
            return $this;
        }

        $this->isValid = false;

        foreach ($violations as $violation) {
            $this->errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $this;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
