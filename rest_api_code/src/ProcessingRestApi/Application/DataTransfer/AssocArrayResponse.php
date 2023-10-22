<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\DataTransfer;

class AssocArrayResponse extends Response
{
    protected $responseAssocArray = [];

    public function __construct($responseAssocArray)
    {
        $this->success = true;
        $this->responseAssocArray = $responseAssocArray;
    }

    public function jsonSerialize(): mixed
    {
        return array_merge(
            [
                "success" => $this->success
            ],
            $this->responseAssocArray
        );
    }
}
