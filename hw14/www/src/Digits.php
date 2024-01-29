<?php

namespace Shabanov\Otusphp;

class Digits
{
    const LETTERS = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z'],
    ];

    private string $digits;

    public function __construct(string $digits)
    {
        $this->digits = $digits;
    }

    public function generate($index): array
    {
        if ($index == strlen($this->digits)) {
            return [''];
        }
        $digit = intval($this->digits[$index]);
        $result = [];
        foreach (self::LETTERS[$digit] as $char) {
            $combinations = $this->generate($index + 1);
            foreach ($combinations as $combination) {
                $result[] = $char . $combination;
            }
        }
        return $result;
    }
}
