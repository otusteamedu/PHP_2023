<?php

declare(strict_types=1);

namespace Ndybnov\Hw04\hw;

use Ndybnov\Hw04\hw\exceptions\EmptyParameterException;
use Ndybnov\Hw04\hw\exceptions\ErrorCountOfBracketsInParameterException;
use Ndybnov\Hw04\hw\exceptions\ErrorInParameterException;
use Ndybnov\Hw04\hw\exceptions\ErrorParameterOnPositionException;
use Ndybnov\Hw04\hw\exceptions\NullParameterException;

class ParsingStr
{
    private function __construct()
    {
    }

    public static function build(): self
    {
        return new self();
    }

    public function parse(?string $str): int
    {
        try {
            return $this->checkString($str);
        } catch (\Exception $exception) {
            throw new $exception($exception->getMessage());
        }
    }

    private function checkString(?string $str): int
    {
        if (!$str) {
            throw new NullParameterException();
        }

        $len = strlen($str);
        if (!$len) {
            throw new EmptyParameterException();
        }

        $stack = new \SplStack();
        $blIsValid = true;
        for ($i = 0; $i < $len; $i++) {
            $isMatched = $this->fmatch($str[$i], $stack);
            if (!$isMatched) {
                throw new ErrorParameterOnPositionException('Error in parameter at position ' . $i);
            }
            $blIsValid &= $isMatched;
        }

        if (!$blIsValid) {
            throw new ErrorInParameterException();
        }

        if ($stack->count()) {
            throw new ErrorCountOfBracketsInParameterException();
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
            return false;
        }

        return true;
    }
}
