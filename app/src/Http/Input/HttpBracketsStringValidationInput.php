<?php

declare(strict_types=1);

namespace Imitronov\Hw4\Http\Input;

use Imitronov\Hw4\Exception\BadRequestException;
use Imitronov\Hw4\Http\Request;
use Imitronov\Hw4\UseCase\BracketsString\BracketsStringValidationInput;

final class HttpBracketsStringValidationInput implements BracketsStringValidationInput
{
    public function __construct(
        private readonly Request $request,
    ) {
    }

    /**
     * @throws BadRequestException
     */
    public function getString(): string
    {
        $string = $this->request->get('string');

        if (null === $string) {
            throw new BadRequestException('Строка не передана.');
        }

        return $this->request->get('string');
    }
}
