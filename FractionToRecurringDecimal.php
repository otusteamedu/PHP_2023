<?php

class Solution
{

    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal($numerator, $denominator)
    {
        $num = ($numerator / $denominator);

        $int = floor($num);
        $rest = substr((string)$num - $int, 2);

        $period = '';
        for ($j = 0; $j < strlen($rest); $j++) {
            $restpart = substr($rest, $j);
            $rlen = strlen($restpart);
            for ($i = 1; $i < ceil($rlen / 2); $i++) {
                if ($rlen % $i) {
                    continue;
                }

                $substr = substr($restpart, 0, $i);
                if (substr(str_repeat($substr, $rlen / $i), 0, -1) == substr($restpart, 0, -1)) {
                    $period = $substr;
                    break;
                }
            }
            if ($period) {
                break;
            }
        }

        $ret = (string)$int;

        if ($period) {
            $ret .= '.';
            if ($j) {
                $ret .= substr($rest, 0, $j);
            }
            $ret .= '(' . $period . ')';
        } elseif ($rest) {
            $ret .= '.' . $rest;
        }

        return $ret;
    }
}
