<?php

namespace Ndybnov\Hw04\hw;

class ParsingStr
{
    private function __construct() {
    }

    public static function build(): self {
        return new self();
    }

    public function parse(?string $str, array &$response): int {
        return $this->checkString($str, $response);
    }

    private function checkString(?string $str, array &$response): int
    {
        $len = strlen($str);
        if (!$len) {
            return 1;
        }

        $stack = new \SplStack();
        $blIsValid = true;
        for ($i = 0; $i < $len; $i++) {
            $isMatched = $this->fmatch($str[$i], $stack);
            if (!$isMatched) {
                $response['ind'] = $i;
                return 4;
            }
            $blIsValid &= $isMatched;
        }

        if (!$blIsValid) {
            return 2;
        }

        if ($stack->count()) {
            return 3;
        }

        return 0;
    }

    private function fmatch($symbol, &$stack): bool
    {
        $skipNotBracketSymbolOrException = true;
        try {
            $doMatch = match ($symbol) {
                '(' => static fn() => $stack->push($symbol),
                ')' => static fn() => $stack->pop(),
                default => static fn() =>
                $skipNotBracketSymbolOrException ?: throw new \Exception('unknown symbol'),
            };
            $doMatch();
        } catch (\Exception $exception) {
            //echo '`'.$symbol.'`';
            return false;
        }

        return true;
    }
}