<?php

declare(strict_types=1);

namespace App\Application\Component\EmailSender;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\NotEmptyString;

interface EmailSenderInterface
{
    public function send(Email $receiver, NotEmptyString $subject, NotEmptyString $message): void;
}
