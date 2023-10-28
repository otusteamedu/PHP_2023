<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Domain\Model;

class Order
{
    const FAKE_ID = -1;

    private int $id;
    private string $status;
    private string $statementNumber;
    private string $filePath;

    public function __construct(
        int $id,
        string $status,
        string $statementNumber,
        string $filePath = ""
    ) {
        $this->id = $id;
        $this->status = $status;
        $this->statementNumber = $statementNumber;
        $this->filePath = $filePath;
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getStatementNumber(): string
    {
        return $this->statementNumber;
    }

    public function setStatementNumber(string $statementNumber): self
    {
        $this->statementNumber = $statementNumber;
        return $this;
    }


    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): self
    {
        $this->filePath = $filePath;
        return $this;
    }
}
