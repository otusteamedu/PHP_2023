<?php

declare(strict_types=1);

namespace Gesparo\Hw;

class App
{
    public const SERVER = 'server';
    public const CLIENT = 'client';

    private const PATH_TO_CONFIG_FILE = '../config/custom.ini';

    public function run(array $arguments): void
    {
        $request = new ArgumentRequest($arguments);
        $config = new ConfigManager((new ConfigParser(self::PATH_TO_CONFIG_FILE))->parse());

        try {
            (new MainController($request, $config))->index();
        } finally {
            // additional protection when __destruct will not call in BaseSocket class
            if (
                $request->getFirstArgument() === self::SERVER &&
                file_exists($config->getSetting('unix_file'))
            ) {
                unlink($config->getSetting('unix_file'));
            }
        }
    }
}