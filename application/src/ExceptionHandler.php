<?php

declare(strict_types=1);

namespace Gesparo\Hw;

class ExceptionHandler
{
    public function handle(\Throwable $exception): void
    {
        fwrite(STDERR, $this->prepareMessage($exception) . PHP_EOL);
    }

    /**
     * @throws \JsonException
     */
    private function prepareMessage(\Throwable $exception): string
    {
        $trace = json_encode($exception->getTrace(), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);

        return <<<EOL
            Exception: '{$exception->getMessage()}'
            Code: '{$exception->getCode()}'
            Trace:
            
            $trace
        EOL;
    }
}
