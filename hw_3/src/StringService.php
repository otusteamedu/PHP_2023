<?php

declare(strict_types=1);

namespace Dgibadullin\Otus;

use Stringy\Stringy;

class StringService
{
    public function convertString(string $s): string
    {
        $result = Stringy::create($s)
            ->collapseWhitespace()
            ->swapCase();
        return (string) $result;
    }
}
