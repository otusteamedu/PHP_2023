<?php

namespace IilyukDmitryi\App\Infrastructure\Mailers;

use Exception;
use IilyukDmitryi\App\Application\Contract\Mailer\MailerInterface;
use IilyukDmitryi\App\Infrastructure\Config\ConfigApp;

class MailerApp
{
    /**
     * @throws Exception
     */
    public static function getMailer(): MailerInterface
    {
        $settings = ConfigApp::get();
        $className = $settings->getMailerName();
        if (!class_exists($className)) {
            throw new Exception("No exists Mailer Class ".$className);
        }

        $mailer = new $className();
        if (!$mailer instanceof MailerInterface) {
            throw new Exception("Mailer error");
        }
        return $mailer;
    }
}
