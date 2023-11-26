<?php

namespace Artyom\Php2023\components;

use Exception;

class BracketsValidator
{
    /**
     * @param $string
     *
     * @return string
     * @throws Exception
     */
    public function validate($string): string
    {
        $string = preg_replace('/[^\(\)]/', '', $string);

        if (!$string) {
            throw new Exception('В строке нет ни одной скобки');
        }

        $bracketCosts = [
            '(' => 1,
            ')' => -1,
        ];

        $bracketsCostsResult = 0;

        foreach (mb_str_split($string) as $bracket) {
            $bracketsCostsResult += $bracketCosts[$bracket];

            if ($bracketsCostsResult < 0) {
                break;
            }
        }

        return $bracketsCostsResult === 0;
    }
}
