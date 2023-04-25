<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Result;

use LucidFrame\Console\ConsoleTable;

class ResultList
{
    private ConsoleTable $result;

    public function __construct(ConsoleTable $result)
    {
        $this->result = $result;
    }

    public function show(): void
    {
        $this->result->display();
    }
}
