<?php

declare(strict_types=1);

namespace Iosh\Mysite;

use Exception;

class BracketsChecker
{
    /**
     * @throws Exception
     */
    public static function check($text): string
    {
        $brackets = 0;
        foreach (static::getSplittedText($text) as $key => $liter) {
            if ($liter === '(') {
                $brackets++;
            }
            if ($liter === ')') {
                if ($brackets > 0) {
                    $brackets--;
                } else {
                    throw new Exception('Закрытие неоткрытого блока');
                }
            }
        }
        if ($brackets != 0) {
            throw new Exception('Блок не закрыт');
        }
        return $text;
    }

    private static function getSplittedText($text): \Generator
    {
        $len = mb_strlen($text);
        for ($iterator = 0; $iterator < $len; $iterator++) {
            yield mb_substr($text, $iterator, 1);
        }
    }
}
