<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Services\Statement;

use Art\Code\Infrastructure\DTO\StatementReceivedDTO;
use Art\Code\Infrastructure\Services\Queue\EmailPublisher\EmailPublisher;
use JsonException;

class StatementService
{
    /**
     * Go to the database, collect data and send a final letter
     * @throws JsonException
     */
    public function createStatement(StatementReceivedDTO $dto, EmailPublisher $emailPublisher): bool
    {
        $emailPublisher->send(['from' => 'config.email', 'title'=> 'letter_title', 'to' => $dto->getEmail(), 'body' => [1, 2, 3, 4] ]);

        return true;
    }

}