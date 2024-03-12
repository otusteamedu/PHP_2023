<?php
declare(strict_types=1);

namespace App\Event;

use App\Entity\User;

readonly class SendNotifyTelegram
{
    public function __construct(
        private User   $user,
        private string $message,
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
