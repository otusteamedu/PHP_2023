<?php

namespace ArtemCherepanov\OtusComposer\Application;

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
