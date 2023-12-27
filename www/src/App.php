<?php

declare(strict_types=1);

namespace Chernomordov\App;

use Chernomordov\App\Chat\Client;
use Chernomordov\App\Chat\Server;
use Exception;

class App
{
    private const CONFIG_PATH = __DIR__ . '/../config/config.ini';

    /**
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $settings = $this->getSettings();

        $this->validateCommandLineArguments();

        $mode = $_SERVER['argv'][1];
        $this->runChat($mode, $settings);
    }

    /**
     *
     * @throws Exception
     */
    private function validateCommandLineArguments(): void
    {
        if (count($_SERVER['argv']) != 2 || !in_array($_SERVER['argv'][1], ['server', 'client'])) {
            throw new Exception('Missing required argument (server, client)');
        }
    }

    /**
     *
     * @param string $mode
     * @param array $settings
     * @throws Exception
     */
    private function runChat(string $mode, array $settings): void
    {
        switch ($mode) {
            case 'server':
            case 'client':
                $this->initChat($mode, $settings);
                break;
        }
    }

    /**
     *
     * @param string $mode
     * @param array $settings
     * @throws Exception
     */
    private function initChat(string $mode, array $settings): void
    {
        $chat = ($mode === 'server') ? new Server($settings['file'], (int)$settings['size']) :
            new Client($settings['file'], (int)$settings['size']);

        $chat->consoleChat();
    }

    /**
     *
     * @return array
     * @throws Exception
     */
    private function getSettings(): array
    {
        if (!file_exists(self::CONFIG_PATH)) {
            throw new Exception('The configuration file is missing');
        }

        $settings = parse_ini_file(self::CONFIG_PATH);

        $this->validateSettings($settings);

        return $settings;
    }

    /**
     *
     * @param array|null $settings
     * @throws Exception
     */
    private function validateSettings(?array $settings): void
    {
        if (!$settings || !isset($settings['file']) || !isset($settings['size'])) {
            throw new Exception('Config param is missing for socket file path or message size.');
        }
    }
}
