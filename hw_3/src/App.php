<?php

declare(strict_types=1);

namespace Dgibadullin\Otus;

use Dgibadullin\OtusComposerPackage\StringProcessor;

class App
{
    private $stringService;
    /**
     * @param StringService $stringService
     */
    public function __construct(StringService $stringService)
    {
        $this->stringService = $stringService;
    }

    public function run()
    {
        $processor = new StringProcessor();
        echo $processor->getLenght('my string');
    }
}
