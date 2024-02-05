<?php

namespace App\Application\Contracts;

use App\Application\Service\Exception\SendMessageException;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;

interface NotifyServiceInterface
{
    /**
     * @throws SendMessageException
     * @throws TransportExceptionInterface
     */
    public function notify(string $chatId, string $message): void;
}
