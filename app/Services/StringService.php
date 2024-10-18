<?php

declare(strict_types=1);

namespace App\Services;

use Salenko\OtusComposerPackage\StringProcessor;

final class StringService
{
    private StringProcessor $stringProcessor;

    public function __construct()
    {
        $this->stringProcessor = new StringProcessor();
    }

    public function getLenString(string $inDataString): void
    {
        echo $this->stringProcessor->getLength($inDataString);
    }
}