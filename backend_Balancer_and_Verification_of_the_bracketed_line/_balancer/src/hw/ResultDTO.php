<?php

namespace Ndybnov\Hw04\hw;

class ResultDTO
{
    private ?string $str;
    private int $codeStatus;
    private int $positionDetectedError;

    private function __construct()
    {
        $this->codeStatus = -1;
        $this->positionDetectedError = -1; //@fixme include ErrorClass
    }

    public static function build(): self
    {
        return new self();
    }

    public function isSuccess(): int
    {
        return (0 === $this->codeStatus);
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

    public function getCodeStatus(): int
    {
        return $this->codeStatus;
    }

    public function setCodeStatus(int $codeStatus): self
    {
        $this->codeStatus = $codeStatus;
        return $this;
    }

    public function getPositionDetectedError(): int
    {
        return $this->positionDetectedError;
    }

    public function setPositionDetectedError(int $positionDetectedError): self
    {
        $this->positionDetectedError = $positionDetectedError;
        return $this;
    }

    public function getStatusMessage(): string
    {
        return $this->isSuccess() ? 'OK' : 'Bad Request';
    }

    public function getStatusCode(): int
    {
        return $this->isSuccess() ? 200 : 400;
    }
}
