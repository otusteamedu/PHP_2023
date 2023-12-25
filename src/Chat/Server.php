<?php

namespace WorkingCode\Hw6\Chat;

use WorkingCode\Hw6\Exception\SettingNotFoundInIniFileException;
use WorkingCode\Hw6\Exception\SocketException;
use WorkingCode\Hw6\Exception\StdoutException;
use WorkingCode\Hw6\Manager\ConfigManager;
use WorkingCode\Hw6\Manager\SocketManager;
use WorkingCode\Hw6\Manager\StdManager;

class Server implements ChatInterface
{
    /**
     * @throws SocketException
     * @throws SettingNotFoundInIniFileException
     * @throws StdoutException
     */
    public function run(): void
    {
        $stdManager = new StdManager();
        $stdManager->stdPrint("start server");

        $configManager = new ConfigManager();
        $socketManager = new SocketManager($configManager->getSocketPatch());
        $socketManager->serverInit();

        do {
            $message = $socketManager->getMessage();

            $socketManager->sendMessage(' Received ' . strlen($message) . ' bytes');
            $stdManager->stdPrint($message);
        } while ($message != 'exit');

        $socketManager->closeSocket();
        $stdManager->stdPrint("stop server");
    }
}
