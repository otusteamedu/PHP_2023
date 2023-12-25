<?php

namespace WorkingCode\Hw6\Chat;

use WorkingCode\Hw6\Exception\SettingNotFoundInIniFileException;
use WorkingCode\Hw6\Exception\SocketException;
use WorkingCode\Hw6\Exception\StdoutException;
use WorkingCode\Hw6\Manager\ConfigManager;
use WorkingCode\Hw6\Manager\SocketManager;
use WorkingCode\Hw6\Manager\StdManager;

class Client implements ChatInterface
{
    /**
     * @throws SettingNotFoundInIniFileException
     * @throws StdoutException
     * @throws SocketException
     */
    public function run(): void
    {
        $stdManager = new StdManager();
        $stdManager->stdPrint("start client");

        $configManager = new ConfigManager();
        $socketManager = new SocketManager($configManager->getSocketPatch());
        $socketManager->clientInit();

        do {
            $inputMessage = $stdManager->getStdin();

            if ($inputMessage) {
                $socketManager->sendMessage($inputMessage);
                $confirmation = $socketManager->getMessage();
                $stdManager->stdPrint($confirmation);
            } else {
                $stdManager->stdPrint('Enter your message');
            }
        } while ($inputMessage != 'exit');

        $socketManager->closeSocket();
        $stdManager->stdPrint("stop client");
    }
}
