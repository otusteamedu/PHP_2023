<?php

declare(strict_types=1);

namespace Imitronov\Hw4\UseCase\BracketsString;

use Imitronov\Hw4\Components\Session;
use Imitronov\Hw4\Enum\BracketsStringValidationCounter;
use Imitronov\Hw4\Exception\ValidationException;
use Imitronov\Hw4\Validator\BracketsValidator;
use Imitronov\Hw4\Validator\NotEmptyStringValidator;

final class BracketsStringValidation
{
    public function __construct(
        private readonly NotEmptyStringValidator $notEmptyStringValidator,
        private readonly BracketsValidator $bracketsValidator,
        private readonly Session $session,
    ) {
    }

    public function handle(BracketsStringValidationInput $input): BracketsStringValidationResult
    {
        $this->session->setIfNull(BracketsStringValidationCounter::SUCCESSFUL->value, 0);
        $this->session->setIfNull(BracketsStringValidationCounter::FAILED->value, 0);

        try {
            $this->notEmptyStringValidator->validate($input->getString());
            $this->bracketsValidator->validate($input->getString());
            $isValid = true;
            $message = 'Строка валидна!';
        } catch (ValidationException $exception) {
            $isValid = false;
            $message = $exception->getMessage();
        }

        if ($isValid) {
            $this->session->increment(BracketsStringValidationCounter::SUCCESSFUL->value);
        } else {
            $this->session->increment(BracketsStringValidationCounter::FAILED->value);
        }

        return new BracketsStringValidationResult(
            $input->getString(),
            $isValid,
            $message,
        );
    }
}
