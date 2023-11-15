<?php

declare(strict_types=1);

namespace Gesparo\HW\Provider\FooProvider;

class Message
{
    private string $message;
    private string $phone;
    private string $atTime;
    private Sender $sender;

    public function __construct(Sender $sender, string $message, string $phone, string $atTime)
    {
        $this->sender = $sender;
        $this->message = $message;
        $this->phone = $phone;
        $this->atTime = $atTime;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): Message
    {
        $this->message = $message;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): Message
    {
        $this->phone = $phone;
        return $this;
    }

    public function getAtTime(): string
    {
        return $this->atTime;
    }

    public function setAtTime(string $atTime): Message
    {
        $this->atTime = $atTime;
        return $this;
    }

    /**
     * @throws \JsonException
     */
    public function send(): void
    {
        $this->sender->send($this);
    }
}
