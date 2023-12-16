<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application\Factory;

use Gesparo\Homework\Application\EnvManager;
use Gesparo\Homework\Application\TelegramManager;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;

class TelegramManagerFactory
{
    public function __construct(private readonly EnvManager $envManager)
    {
    }

    /**
     * @throws TelegramException
     */
    public function create(): TelegramManager
    {
        new Telegram($this->envManager->getTelegramBotToken(), $this->envManager->getTelegramBotName());

        return new TelegramManager($this->envManager);
    }
}