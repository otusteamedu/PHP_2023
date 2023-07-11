<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Infrastructure\Validator\Event;

use Imitronov\Hw12\Domain\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

final class RequestCreateEventsInputValidator
{
    /**
     * @throws InvalidArgumentException
     */
    public function validate($priority, $conditions, $event): void
    {
        $validator = Validation::createValidator();
        $input = [
            'priority' => $priority,
            'conditions' => $conditions,
            'event' => $event,
        ];
        $constraint = new Assert\Collection([
            'priority' => [
                new Assert\NotBlank(),
                new Assert\Positive(),
            ],
            'conditions' => [
                new Assert\Required(),
                new Assert\NotBlank(),
            ],
            'event' => [
                new Assert\Required(),
                new Assert\NotBlank(),
                new Assert\Collection([
                    'name' => [
                        new Assert\Required(),
                        new Assert\Type('string'),
                    ],
                    'type' => [
                        new Assert\Required(),
                        new Assert\Type('string'),
                    ],
                    'dateTime' => [
                        new Assert\Required(),
                        new Assert\Type('string'),
                    ],
                ]),
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
