<?php

declare(strict_types=1);

namespace Art\Php2023;

class Phrases
{
    protected static array $phrases = [
        'client_start_chat' => "Chat has been started. You can write \"{exit}\" to finish.\r\n",
        'client_finish_chat' => "Chat has been finished. Bye bye\r\n",
        'server_finish_chat' => "Client finished the chat. Bye bye\r\n",
        'enter_message'     => "\nEnter your message: ",
        'server_response'   => "Server response: {text}\n\n",
        'waiting_messages'  => "Waiting for incoming messages...\n\n",
        'received_message'  => "Received message: \"{message}\"\n",
        'received_bytes'    => "Received {bytes} bytes",
        'empty_text'    => "Need to enter your message\n",
    ];

    public static function show(string $key, array $replacements = []): void
    {
        self::prepare('show', $key, $replacements);
    }

    public static function get(string $key, array $replacements = []): string
    {
        return self::prepare('get', $key, $replacements);
    }

    protected static function prepare(string $action, string $key, array $replacements = [])
    {
        if (!($phrase = self::$phrases[$key])) {
            throw new \InvalidArgumentException("Error: Missing phrase with key {$key}");
        }

        if ($replacements) {
            $phrase = strtr($phrase, $replacements);
        }

        switch ($action) {
            case 'show':
                echo $phrase;
                break;
            case 'get':
                return $phrase;
        }
    }
}
