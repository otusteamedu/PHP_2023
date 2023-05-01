<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Application\UseCase;

use Twent\BracketsValidator\Application\DTO\StringDTO;
use Twent\BracketsValidator\Application\Exceptions\EmptyString;
use Twent\BracketsValidator\Domain\Validator;
use Twent\BracketsValidator\Domain\ValueObject\InputString;

final class ValidateBracketsUseCase
{
    public function __construct(
        private readonly Validator $validator = new Validator()
    ) {
    }

    /**
     * @throws EmptyString
     */
    public function run(StringDTO $stringDTO): bool
    {
        $string = new InputString($stringDTO->getValue());

        return $this->validator->run($string);
    }
}
