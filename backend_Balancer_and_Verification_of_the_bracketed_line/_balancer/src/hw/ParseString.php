<?php

declare(strict_types=1);

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
        try {
            ParsingStr::build()->parse($str);

            return ResultDTO::build()
                ->setString($str)
                ->setInfoMessage('success');
        } catch (\Exception $exception) {
            return ResultDTO::build()
                ->setString($str)
                ->setInfoMessage($exception->getMessage());
        }
    }
}
