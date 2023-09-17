<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Telegram;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class TelegramClient
{
    protected static ?TelegramClient $instance = null;
    private Client $client;
    private string $token;

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function post(int $chatId, string $text): void
    {
        try {
            $this->client->post("https://api.telegram.org/bot{$this->token}/sendMessage", [
                RequestOptions::JSON => [
                    'chat_id' => $chatId,
                    'text' => $text,
                ]
            ]);
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
    }

    protected function __construct()
    {
        $this->client = new Client();
        $this->token = getenv('TELEGRAM_TOKEN');
    }
}
