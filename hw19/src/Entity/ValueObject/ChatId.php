<?php

declare(strict_types=1);

namespace App\Entity\ValueObject;

use App\Entity\Exception\DataException;

class ChatId
{
    private string $chatId;

    public function __construct(string $chatId)
    {
        $this->assertChatIdIsValid($chatId);

        $this->chatId = $chatId;
    }

    public function __toString(): string
    {
        return $this->chatId;
    }

    public function getValue(): string
    {
        return $this->chatId;
    }

    /**
     * @throws DataException
     */
    private function assertChatIdIsValid(string $id): void
    {
        if (1 != preg_match('/^\d{9}$/', $id)) {
            throw new DataException('ChatId incorrect.');
        }
    }
}
