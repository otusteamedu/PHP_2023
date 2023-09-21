<?php

namespace IilyukDmitryi\App\Application\Dto;

class MessageReciveResult
{
    public function __construct(protected bool $messageRecive, protected bool $sendEmail)
    {
    }

    /**
     * @return bool
     */
    public function isSendEmail(): bool
    {
        return $this->sendEmail;
    }

    /**
     * @return bool
     */
    public function isMessageRecive(): bool
    {
        return $this->messageRecive;
    }
}
