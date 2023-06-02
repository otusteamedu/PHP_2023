<?php

declare(strict_types=1);

namespace nikitaglobal\controllers\client;

use nikitaglobal\Phrases;

/**
 * Class for sending outgoing messages
 */
class Client
{
    public function sendMessage($socket): void
    {
        $socket->connect();
        Phrases::show('client_start_chat', ['{exit}' => $socket->exitCommand]);
        while (true) {
            $message = readline(Phrases::get('enter_message'));
            if ($message === '') {
                Phrases::show('empty_text');
                continue;
            }
            $socket->write($message);
            if ($message === $socket->exitCommand) {
                Phrases::show('client_finish_chat');
                $socket->close();
                break;
            }
            Phrases::show('server_response', ['{text}' => $socket->read()]);
        }
    }
}
