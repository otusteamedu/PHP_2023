<?php

declare(strict_types=1);

namespace Aporivaev\Hw09;

use Exception;

class App
{
    const MODE_UNKNOWN = 0;
    const MODE_SERVER = 10;
    const MODE_CLIENT = 20;

    private int $mode = self::MODE_UNKNOWN;
    private ?string $name = null;
    private int $nameRandLen = 5;
    public function __construct()
    {
        mb_internal_encoding('UTF-8');
        $this->parseArg();
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        switch ($this->mode) {
            case self::MODE_SERVER:
                $server = new Server('/tmp/server.sock');
                echo "Server started\n";
                $server->run();
                break;
            case self::MODE_CLIENT:
                if (empty($this->name)) {
                    $this->name = 'Client_' . bin2hex(random_bytes($this->nameRandLen));
                }
                echo "Client ($this->name) started\n";
                $server = new Client('/tmp/server.sock', $this->name);
                $server->run();
                break;
            default:
                $this->showHelp();
        }
        echo "Exit\n";
    }

    private function parseArg()
    {
        global $argv, $argc;

        if ($argc >= 2) {
            $mode = strtolower($argv[1]);
            switch ($mode) {
                case 'server':
                    $this->mode = self::MODE_SERVER;
                    break;
                case 'client':
                    $this->mode = self::MODE_CLIENT;
                    break;
            }
        }
        if (isset($argv[2]) && is_string($argv[2])) {
            $this->name = $argv[2];
        }
    }
    private function showHelp(): void
    {
        echo "Usage: index.php OPTIONS [USERNAME]\n\n";
        echo "OPTIONS:\n";
        echo "\t-h, --help\t Show this help\n";
        echo "\tserver\t\t Start the server\n";
        echo "\tclient\t\t Start the client\n";
        echo "USERNAME\t\t Client name (optional)\n";
    }

}
