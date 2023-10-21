<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\DataTransfer;

class StringResponse extends Response
{
    protected $responseStringName;
    protected $responseStringValue;

    public function __construct($responseStringName, $responseStringValue)
    {
        $this->success = true;
        $this->responseStringName = $responseStringName;
        $this->responseStringValue = $responseStringValue;
    }

    public function jsonSerialize(): mixed
    {
        return [
            "success" => $this->success,
            $this->responseStringName => $this->responseStringValue
        ];
    }
}
