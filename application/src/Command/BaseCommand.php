<?php

declare(strict_types=1);

namespace Gesparo\ES\Command;

use Gesparo\ES\OutputHelper;

abstract class BaseCommand implements RunCommandInterface
{
    protected OutputHelper $outputHelper;

    public function __construct()
    {
        $this->outputHelper = new OutputHelper();
    }
}