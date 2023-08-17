<?php

namespace ArtemCherepanov\OtusComposer\Infrastructure;

use ArtemCherepanov\OtusComposer\Application\StringService;

class StringCommand
{
    private StringService $stringService;

    public function __construct(StringService $stringService)
    {
        $this->stringService = $stringService;
    }

    public function execute()
    {
        $s = 'foo bar';

        echo $this->stringService->convertString($s);
    }
}
