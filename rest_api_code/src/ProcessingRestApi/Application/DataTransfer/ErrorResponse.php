<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\DataTransfer;

class ErrorResponse extends Response
{
    protected string $errorDescription;

    public function __construct($errorDescription)
    {
        $this->success = false;
        $this->errorDescription = $errorDescription;
    }

    public function jsonSerialize(): mixed
    {
        return [
            "success" => $this->success,
            "errorDescription" => $this->errorDescription
        ];
    }
}
