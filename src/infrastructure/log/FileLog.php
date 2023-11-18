<?php

namespace src\infrastructure\log;

use src\PathHomeSource;

class FileLog implements LogInterface
{
    public function info(string $message): void
    {
        $resource = \fopen(self::getPath('info'), 'wb');
        \fwrite($resource, $message . PHP_EOL);
        \fclose($resource);
    }

    public function warning(string $message): void
    {
        $resource = \fopen(self::getPath('warning'), 'wb');
        \fwrite($resource, $message . PHP_EOL);
        \fclose($resource);
    }

    public function error(string $message): void
    {
        $resource = \fopen(self::getPath('error'), 'wb');
        \fwrite($resource, $message . PHP_EOL);
        \fclose($resource);
    }

    private static function getPath(string $nameLogFile): string
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [PathHomeSource::get() , 'var', 'log', $nameLogFile . '.log']
        );
    }
}
