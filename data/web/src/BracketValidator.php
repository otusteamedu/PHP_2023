<?php
declare(strict_types=1);

namespace src;

class BracketValidator {
    public static function validate(string $bracket): bool {
        if (empty($bracket)) {
            return false;
        }

        $sum_bracket = 0;

        foreach(str_split($bracket) as $brace) {
            if ($brace == "(") {
                $sum_bracket++;
            } else if ($brace == ")") {
                $sum_bracket--;
            } else {
                return false;
            };

            if ($sum_bracket < 0) {
                return false;
            }
        }

        return ($sum_bracket == 0);
    }
}
