<?php

namespace IilyukDmitryi\App\Infrastructure\Broker;

use Exception;
use IilyukDmitryi\App\Infrastructure\Broker\Base\ReciverBrokerInterface;
use IilyukDmitryi\App\Infrastructure\Broker\Base\SenderBrokerInterface;
use IilyukDmitryi\App\Infrastructure\Config\ConfigApp;

class BrokerApp
{
    public static function getReciver(): ReciverBrokerInterface
    {
        $settings = ConfigApp::get();
        $className = $settings->getReciverName();
        if (!class_exists($className)) {
            throw new Exception("No exists Reciver Class");
        }

        $reciver = new $className();
        if (!$reciver instanceof ReciverBrokerInterface) {
            throw new Exception("Reciver error");
        }
        return $reciver;
    }

    public static function getSender(): SenderBrokerInterface
    {
        $settings = ConfigApp::get();
        $className = $settings->getSenderName();
        if (!class_exists($className)) {
            throw new Exception("No exists Sender Class");
        }

        $Broker = new $className();
        if (!$Broker instanceof SenderBrokerInterface) {
            throw new Exception("Sender error");
        }
        return $Broker;
    }
}
