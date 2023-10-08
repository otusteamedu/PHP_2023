<?php

declare(strict_types=1);

namespace App\Application\Component;

use App\Domain\ValueObject\Email;

interface EmailSenderInterface
{
    public function send(Email $email, string $subject, string $message): void;
}
