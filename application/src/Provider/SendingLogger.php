<?php

declare(strict_types=1);

namespace Gesparo\HW\Provider;

class SendingLogger
{
    private string $pathToFile;

    public function __construct(string $pathToFile)
    {
        $this->pathToFile = $pathToFile;
    }

    /**
     * @throws \JsonException
     */
    public function log(array $data): void
    {
        $stringData = json_encode($data, JSON_THROW_ON_ERROR);
        $time = date('Y-m-d H:i:s');
        $text = <<<TEXT
        [$time] $stringData
        TEXT;

        file_put_contents($this->pathToFile, $text . PHP_EOL, FILE_APPEND);
    }
}
