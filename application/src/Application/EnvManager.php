<?php

declare(strict_types=1);

namespace Gesparo\Homework\Application;

class EnvManager
{
    private const RABBITMQ_PORT = 'RABBITMQ_PORT';
    private const RABBITMQ_USER = 'RABBITMQ_DEFAULT_USER';
    private const RABBITMQ_PASSWORD = 'RABBITMQ_DEFAULT_PASS';
    private const TELEGRAM_BOT_NAME = 'TELEGRAM_BOT_NAME';
    private const TELEGRAM_BOT_TOKEN = 'TELEGRAM_BOT_TOKEN';
    private const TELEGRAM_CHAT_ID = 'TELEGRAM_CHAT_ID';

    public const VARIABLES = [
        self::RABBITMQ_PORT,
        self::RABBITMQ_USER,
        self::RABBITMQ_PASSWORD,
        self::TELEGRAM_BOT_NAME,
        self::TELEGRAM_BOT_TOKEN,
        self::TELEGRAM_CHAT_ID,
    ];

    public function getRabbitMqUser(): string
    {
        return $_ENV[self::RABBITMQ_USER];
    }

    public function getRabbitMqPassword(): string
    {
        return $_ENV[self::RABBITMQ_PASSWORD];
    }

    public function getInputChannelName(): string
    {
        return 'bank_statement_input';
    }

    public function getOutputChannelName(): string
    {
        return 'bank_statement_output';
    }

    public function getRabbitMqPort(): int
    {
        return (int) $_ENV[self::RABBITMQ_PORT];
    }
}
