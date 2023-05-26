<?php

declare(strict_types=1);

namespace Vyacheslavlebedev\Php2023\Infrastructure;

use VyacheslavLebedev\PalindromeCounter\PalindromeCounter;

class PalindromeCountCommand
{
    public function execute(): void
    {
        $pc = new PalindromeCounter();
        echo $pc->count(['Eva, can I see bees in a cave?', 'hello world', 'madam']);
    }
}
