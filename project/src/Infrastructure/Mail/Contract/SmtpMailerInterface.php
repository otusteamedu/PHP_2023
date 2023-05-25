<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Mail\Contract;

interface SmtpMailerInterface
{
    public function send(string $email, string $subject, string $message): void;
}
