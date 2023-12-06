<?php
declare(strict_types=1);

namespace Shabanov\Otusphp;

use Shabanov\Otusphp\Socket\AbstractSocket;
use Shabanov\Otusphp\Socket\ServerSocket;
use Shabanov\Otusphp\Socket\ClientSocket;

class App
{
    private AbstractSocket $socket;
    public function __construct($argv)
    {
        if (isset($argv[1])) {
            switch ($argv[1]) {
                case 'server':
                    $this->socket = new ServerSocket();
                    break;
                case 'client':
                    $this->socket = new ClientSocket();
                    break;
                default:
                    throw new \Exception('error cli argument');
            }
        } else {
            throw new \Exception('not cli argument');
        }
    }

    public function run(): void
    {
        $this->socket->run();
    }
}
