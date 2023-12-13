<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Message;

class ApplicationForm
{
    private Email $email;
    private Message $message;
    private Status $status;
    private ?int $id = null;

    public function __construct(Email $email, Message $message, Status $status)
    {
        $this->email = $email;
        $this->message = $message;
        $this->status = $status;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function setMessage(Message $message): void
    {
        $this->message = $message;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->getId(),
            "email" => $this->getEmail()->getValue(),
            "message" => $this->getMessage()->getValue(),
            "status" => $this->getStatus()->getName()->getValue()
        ];
    }
}
