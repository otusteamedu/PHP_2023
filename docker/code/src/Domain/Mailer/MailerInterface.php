<?php


namespace IilyukDmitryi\App\Domain\Mailer;

interface MailerInterface
{
    public function sendMail(string $emailTo, string $subject, string $message): bool;
}