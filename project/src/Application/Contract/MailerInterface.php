<?php

declare(strict_types=1);

namespace Vp\App\Application\Contract;

interface MailerInterface
{
    public function send(string $email, string $subject, string $message): void;
}
