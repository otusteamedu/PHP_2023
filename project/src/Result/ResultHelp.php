<?php

declare(strict_types=1);

namespace Vp\App\Result;

class ResultHelp
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function print(): void
    {
        fwrite(STDOUT, $this->message . PHP_EOL);
    }
}
