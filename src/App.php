<?php


declare(strict_types=1);

namespace DKhalikov\Hw5;

use Exception;
use DKhalikov\Hw5\Chat\Client;
use DKhalikov\Hw5\Chat\Server;

class App
{
    const CONFIG_PATH = __DIR__ . '/../config/config.ini';

    /**
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $settings = $this->getSettings();

        if (count($_SERVER['argv']) != 2 || !in_array($_SERVER['argv'][1], ['server', 'client'])) {
            throw new Exception('Missing required argument (server, client)');
        }

        switch ($_SERVER['argv'][1]) {
            case 'server':
                (new Server($settings['file'], (int)$settings['size']))
                    ->consoleChat();
                break;
            case 'client':
                (new Client($settings['file'], (int)$settings['size']))
                    ->consoleChat();
                break;
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getSettings(): array
    {
        if (!file_exists(self::CONFIG_PATH)) {
            throw new Exception('The configuration file is missing');
        }

        $settings = parse_ini_file(self::CONFIG_PATH);

        if (!isset($settings['file']) || !isset($settings['size'])) {
            throw new Exception('Config param is missing for socket file path or message size.');
        }

        return $settings;
    }
}
