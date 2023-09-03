<?php

declare(strict_types=1);

namespace App\Statement;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
final class NotifyUserListener
{
    /**
     * Super simple user notifier by email
     */
    public function __invoke(StatementIsGeneratedEvent $event): void
    {
        $to = "pirojok167@gmail.com";
        $subject = "Bank statement";
        $message = "You statement is generated";
        $headers = "From: lexa461@mail.ru";

        mail($to, $subject, $message, $headers);
    }
}
