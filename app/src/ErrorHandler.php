<?php

declare(strict_types=1);

namespace Root\App;

class ErrorHandler
{
    /** @noinspection SpellCheckingInspection */
    public function __invoke(int $errno,
                             string $errstr,
                             ?string $errfile = null,
                             ?int $errline = null,
                             ?array $errcontext = []
    ): void
    {
        /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
        Response::echo(false, "Error: {$errno}, {$errstr}. ({$errfile} : {$errline})");
    }
}
