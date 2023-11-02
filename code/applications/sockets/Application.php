<?php

/**
 * Описание класса
 * php version 8.2.8
 *
 * @category ItIsDepricated
 * @package  AmedvedevPHP2023Otus
 * @author   Alex 150Rus <alex150rus@outlook.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @Version  GIT: 1.0.0
 * @link     http://github.com/Alex150Rus My_GIT_profile
 */

declare(strict_types=1);

namespace Amedvedev\code\applications\sockets;

use Amedvedev\code\applications\sockets\services\SocketService;
use Amedvedev\code\config\Config;

class Application
{
    private readonly array $argv;
    public function __construct(array $argv)
    {
        Config::init();
        $this->argv = $argv;
    }

    public function run()
    {
        $socketService = new SocketService();
        $socketService->strategy($this->argv);
    }
}
