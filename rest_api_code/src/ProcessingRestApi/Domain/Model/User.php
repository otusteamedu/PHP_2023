<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Domain\Model;

class User
{
    const FAKE_ID = -1;


    private int $id;
    private string $login;
    private string $passwordSha1;

    public function __construct(
        int $id,
        string $login,
        string $passwordSha1
    ) {
        $this->id = $id;
        $this->login = $login;
        $this->passwordSha1 = $passwordSha1;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;
        return $this;
    }

    public function getPasswordSha1(): string
    {
        return $this->passwordSha1;
    }

    public function setPasswordSha1(string $passwordSha1): self
    {
        $this->passwordSha1 = $passwordSha1;
        return $this;
    }
}
