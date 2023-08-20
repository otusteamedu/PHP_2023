<?php

declare(strict_types=1);

namespace Ndybnov\Hw04\hw;

class ResultDTO
{
    private ?string $str;
    private int $codeStatus;
    private string $infoMessage;

    private function __construct()
    {
    }

    public static function build(): self
    {
        return new self();
    }

    public function getInfoMessage(): string
    {
        return $this->infoMessage;
    }

    public function setInfoMessage(string $infoMessage): self
    {
        $this->infoMessage = $infoMessage;
        $this->codeStatus = ('success' === $infoMessage) ? 0 : -1;
        return $this;
    }

    public function getString(): ?string
    {
        return $this->str;
    }

    public function setString(?string $str): self
    {
        $this->str = $str;
        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->isSuccess() ? 200 : 400;
    }

    private function isSuccess(): bool
    {
        return (0 === $this->codeStatus);
    }
}
