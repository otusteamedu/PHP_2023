<?php

declare(strict_types=1);

namespace Ndybnov\Hw04\hw;

use Psr\Http\Message\ServerRequestInterface as Request;

class MainCommand
{
    private function __construct()
    {
    }

    public static function build(): self
    {
        return new self();
    }

    public function run(Request $request): ResultDTO
    {
        $string = ParameterString::build()->getValue($request);

        return ParseString::build()->makeResult($string);
    }
}
