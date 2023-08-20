<?php

namespace Ndybnov\Hw04\hw;

class ParseString
{
    private function __construct()
    {
    }

    public static function build(): self
    {
        return new self();
    }

    public function makeResult(?string $str): ResultDTO
    {
        $response = [];
        $checkedStatus = ParsingStr::build()->parse($str, $response);

        return ResultDTO::build()
            ->setString($str)
            ->setCodeStatus($checkedStatus)
            ->setPositionDetectedError($response['ind'] ?? -1);
    }
}
