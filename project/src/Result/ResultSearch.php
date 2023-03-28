<?php

declare(strict_types=1);

namespace Vp\App\Result;

use LucidFrame\Console\ConsoleTable;

class ResultSearch
{
    private bool $success;
    private ?string $message;
    private ?ConsoleTable $result;

    public function __construct(bool $success, ?string $message = null, ?ConsoleTable $result = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->result = $result;
    }

    public function print(): void
    {
        fwrite(STDOUT, $this->message . PHP_EOL);
        $this->result->display();
    }
}
