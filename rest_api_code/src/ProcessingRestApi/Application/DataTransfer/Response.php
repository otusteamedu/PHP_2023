<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\DataTransfer;

class Response implements \JsonSerializable
{
    protected bool $success;

    public function __construct(bool $success)
    {
        $this->success = $success;
    }

    public function jsonSerialize(): mixed
    {
        return [
            "success" => $this->success
        ];
    }
}
