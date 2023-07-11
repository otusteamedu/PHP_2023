<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Infrastructure\Validator\Event;

use Imitronov\Hw12\Domain\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

final class RequestSearchEventsInputValidator
{
    /**
     * @throws InvalidArgumentException
     */
    public function validate($conditions): void
    {
        $validator = Validation::createValidator();
        $input = [
            'conditions' => $conditions,
        ];
        $constraint = new Assert\Collection([
            'conditions' => [
                new Assert\Required(),
                new Assert\NotBlank(),
            ],
        ]);
        $violations = $validator->validate($input, $constraint);

        if ($violations->count() > 0) {
            $userMessages = [];

            foreach ($violations as $violation) {
                $userMessages[$violation->getPropertyPath()] = $violation->getMessage();
            }

            throw new InvalidArgumentException('Validation error', $userMessages);
        }
    }
}
