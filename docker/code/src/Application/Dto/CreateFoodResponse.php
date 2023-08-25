<?php

namespace IilyukDmitryi\App\Application\Dto;

class CreateFoodResponse
{
    /**
     * @param string $message
     * @param bool $error
     */
    public function __construct(protected string $message, protected bool $error)
    {
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }
}
