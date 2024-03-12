<?php
declare(strict_types=1);

namespace App\Entity;

class User
{
    public function __construct(
        private ?int   $id = null,
        private string $surname,
        private string $name,
        private string $patronymic,
        private string $telegramChatId,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPatronymic(): string
    {
        return $this->patronymic;
    }

    public function setPatronymic(string $patronymic): self
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    public function getTelegramChatId(): string
    {
        return $this->telegramChatId;
    }

    public function setTelegramChatId(string $telegramChatId): self
    {
        $this->telegramChatId = $telegramChatId;

        return $this;
    }
}
