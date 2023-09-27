<?php

namespace IilyukDmitryi\App\Infrastructure\Messanger;

use Exception;
use IilyukDmitryi\App\Application\Contract\Messenger\MessengerInterface;
use IilyukDmitryi\App\Infrastructure\Config\ConfigApp;

class MessengerApp
{
    public static function getMessanger(): MessengerInterface
    {
        $settings = ConfigApp::get();
        $className = $settings->getMessangerName();
        if (!class_exists($className)) {
            throw new Exception("No exists Messanger Class");
        }

        $messanger = new $className();
        if (!$messanger instanceof MessengerInterface) {
            throw new Exception("Reciver error");
        }
        return $messanger;
    }
}
