<?php

namespace IilyukDmitryi\App\Workers\Socket;

use Exception;

class Client extends Socket
{
    public function run(): void
    {
        $this->serverTurnOn();
        $listenGen = $this->listenStdin();
        while ($mess = $listenGen->current()) {
            echo $mess;
            $listenGen->next();
        }
    }

    /**
     * @throws Exception
     */
    protected function serverTurnOn(): void
    {
        $this->createStream();
    }

    /**
     * @throws Exception
     */
    private function createStream(): void
    {
        $this->stream = stream_socket_client(static::SOCKET_ADRESS . static::SOCKET_FILE, $errno, $errstr);
        if (!$this->stream) {
            throw new Exception("$errstr ($errno)");
        }
    }

    /**
     * @throws Exception
     */
    private function listenStdin()
    {
        yield '---=== Client running ===---' . PHP_EOL;
        while (true) {
            $messageCli = $this->getMessageFromCli();
            $this->sendMessage($messageCli);
            $messageServer = $this->getRemoteMessage();
            if ($this->isMessageDelivered($messageServer, $messageCli)) {
                yield "Message delivered! Write new message!" . PHP_EOL;
                if ($this->isExitMessage($messageCli)) {
                    yield "---=== Client turn off ===---- " . PHP_EOL;
                    $this->serverTurnOff();
                    yield;
                }
            } else {
                yield "Message not delivered,  send message = '" . $messageCli . "', server received ='" . $messageServer . "' " . PHP_EOL;
            }
        }
    }

    protected function getMessageFromCli(): string
    {
        return trim(fgets(STDIN)) . PHP_EOL;
    }

    protected function serverTurnOff(): void
    {
        $this->closeStream();
    }
}
