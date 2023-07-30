<?php

namespace IilyukDmitryi\App\Infrastructure\Mailers;

use IilyukDmitryi\App\Application\Contract\Mailer\MailerInterface;
use PHPMailer\PHPMailer\Exception;

class FileLog implements MailerInterface
{
    private const FILENAME_LOG = "mail.log";

    /**
     * @throws Exception
     */


    /**
     * @param string $emailTo
     * @param string $subject
     * @param string $message
     * @return bool
     * @throws Exception
     */
    public function sendMail(string $emailTo, string $subject, string $message): bool
    {
        $data = ['$emailTo' => $emailTo, '$subject' => $subject, '$message' => $message];
        $file = $_SERVER["DOCUMENT_ROOT"] . '/' . static::FILENAME_LOG;
        file_put_contents(
            $file,
            date("d.m.Y H:i:s") . '#' . substr(microtime(true) . ' ', -5, 5) . ' ---- ' . PHP_EOL . var_export(
                $data,
                1
            ) . PHP_EOL . '----' . PHP_EOL,
            FILE_APPEND
        );
        return true;
    }
}
