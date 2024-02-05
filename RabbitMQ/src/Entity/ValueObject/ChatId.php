<?php

declare(strict_types=1);

namespace App\Entity\ValueObject;

use App\Entity\Exception\ChatIdNotValidException;

class ChatId
{
    private string $chatId;

    /**
     * @throws ChatIdNotValidException
     */
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
     * @throws ChatIdNotValidException
     */
    private function assertChatIdIsValid(string $id): void
    {
        if (1 != preg_match('/^\d{9}$/', $id)) {
            throw new ChatIdNotValidException('ChatId is not valid.');
        }
    }
}
