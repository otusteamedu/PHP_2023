<?php


namespace IilyukDmitryi\App\Application\Contract\Mailer;

interface MailerInterface
{
    public function sendMail(string $emailTo, string $subject, string $message): bool;
}