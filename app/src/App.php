<?php

declare(strict_types=1);

namespace Aporivaev\Hw09;

use Exception;

class App
{
    const MODE_UNKNOWN = 0;
    const MODE_SERVER = 10;
    const MODE_CLIENT = 20;

    const CONFIG_DEFAULT_SOCKET = '/tmp/socket/server';

    private int $mode = self::MODE_UNKNOWN;
    private int $nameRandLen = 5;

    private ?string $configFile = null;
    private ?string $config_socket = self::CONFIG_DEFAULT_SOCKET;
    private ?string $config_name = null;

    public function __construct()
    {
        mb_internal_encoding('UTF-8');
        $this->parseArg();
        if (!empty($this->configFile)) {
            $this->parseConfig();
        }
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        switch ($this->mode) {
            case self::MODE_SERVER:
                $server = new Server($this->config_socket, $this->config_name);
                echo "Server ({$server->name}) started\n";
                $server->run();
                break;
            case self::MODE_CLIENT:
                $client = new Client($this->config_socket, $this->config_name);
                echo "Client ({$client->name}) started\n";
                $client->run();
                break;
            default:
                $this->showHelp();
        }
        echo "Exit\n";
    }

    private function parseArg()
    {
        global $argv, $argc;
        $index = 0;
        $opt = getopt('c:', [], $index);
        if (!empty($opt['c'])) {
            $this->configFile = $opt['c'];
        }

        $mode = isset($argv[$index]) ? strtolower($argv[$index]) : null;
        switch ($mode) {
            case 'server':
                $this->mode = self::MODE_SERVER;
                break;
            case 'client':
                $this->mode = self::MODE_CLIENT;
                break;
        }
        if (isset($argv[$index + 1]) && is_string($argv[$index + 1])) {
            $this->config_name = $argv[$index + 1];
        }
    }
    private function parseConfig(): void
    {
        $config = parse_ini_file($this->configFile, true);
        if (is_array($config) && count($config) > 0) {
            switch ($this->mode) {
                case self::MODE_SERVER:
                    $section = $config['server'] ?? null;
                    $this->config_socket = $section['socket'] ?? self::CONFIG_DEFAULT_SOCKET;
                    $this->config_name = $section['name'] ?? null;
                    break;
                case self::MODE_CLIENT:
                    $section = $config['client'] ?? null;
                    $this->config_socket = $section['socket'] ?? self::CONFIG_DEFAULT_SOCKET;
                    $this->config_name = $section['name'] ?? null;
                    break;
            }
        }
    }
    private function showHelp(): void
    {
        echo "Usage: index.php OPTIONS [USERNAME]\n\n";
        echo "OPTIONS:\n";
        echo "\t-c filename\t Ini config\n";
        echo "\tserver\t\t Start the server\n";
        echo "\tclient\t\t Start the client\n";
        echo "USERNAME\t\t Client name (optional)\n";
    }
}
