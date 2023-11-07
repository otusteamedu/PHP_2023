<?php

declare(strict_types=1);

namespace Gesparo\ES\DataSynchronization;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class ChunkDataSender
{
    private const MAX_BUFFER_SIZE = 2000;

    private Client $esClient;
    private array $buffer = [];
    private int $amountInBuffer = 0;

    public function __construct(Client $client)
    {
        $this->esClient = $client;
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function push(FileLine $line): void
    {
        $this->addToBuffer($line);

        if ($this->isBufferFull()) {
            $this->sendBuffer();
        }
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function finish(): void
    {
        if ($this->amountInBuffer > 0) {
            $this->sendBuffer();
        }
    }

    private function addToBuffer(FileLine $line): void
    {
        $this->buffer[] = $line->getValue();
        ++$this->amountInBuffer;
    }

    private function isBufferFull(): bool
    {
        return count($this->buffer) === self::MAX_BUFFER_SIZE;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    private function sendBuffer(): void
    {
        $this->esClient->bulk([
            'body' => $this->buffer
        ]);

        $this->buffer = [];
        $this->amountInBuffer = 0;
    }
}
