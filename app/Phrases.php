<?php

declare(strict_types=1);

namespace nikitaglobal;

class Phrases
{
    protected static array $phrases = [
        'client_start_chat' => "Hello. Type \"{exit}\" to stop.\r\n",
        'client_finish_chat' => "Bye\r\n",
        'server_finish_chat' => "Client left\r\n",
        'enter_message'     => "\nEnter your message: ",
        'server_response'   => "Server response: {text}\n\n",
        'waiting_messages'  => "Waiting for messages\n\n",
        'received_message'  => "Received message: \"{message}\"\n",
        'received_bytes'    => "Received {bytes} bytes",
        'empty_text'    => "Enter your text\n",
    ];

    /**
     * Show phrase
     *
     * @param string $key
     * @param array $replacements
     *
     * return void
    */
    public static function show(string $key, array $replacements = []): void
    {
        self::prepare('show', $key, $replacements);
    }

    /**
     * Get phrase
     *
     * @param string $key
     * @param array $replacements
     *
     * @return string
     */
    public static function get(string $key, array $replacements = []): string
    {
        return self::prepare('get', $key, $replacements);
    }

    /**
     * Prepare phrase
     *
     * @param string $action
     * @param string $key
     * @param array $replacements
     *
     * @return void|string
     */
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
