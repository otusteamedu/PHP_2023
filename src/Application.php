<?php

namespace WorkingCode\Hw6;

use WorkingCode\Hw6\Chat\Client;
use WorkingCode\Hw6\Chat\Server;
use WorkingCode\Hw6\Exception\ArgumentInvalidException;
use WorkingCode\Hw6\Exception\SettingNotFoundInIniFileException;
use WorkingCode\Hw6\Exception\SocketException;
use WorkingCode\Hw6\Exception\StdoutException;

class Application
{
    /**
     * @throws SettingNotFoundInIniFileException
     * @throws ArgumentInvalidException
     * @throws StdoutException
     * @throws SocketException
     */
    public function run(string $nameApplication): void
    {
        $application = match ($nameApplication) {
            'server' => new Server(),
            'client' => new Client(),
            default => throw new ArgumentInvalidException("передан не верный параметр\n"),
        };
        $application->run();
    }
}
