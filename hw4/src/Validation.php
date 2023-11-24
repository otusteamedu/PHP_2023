<?php
declare(strict_types=1);

   function get_brackets($text)
    {
        $brackets = preg_replace("/[^\(\)]/i", '', $text);
        return $brackets;
    }

    function is_full($text = "")
    {
        if ($text == "") {
            return true;
        } else {
            return false;
        }
    }

    function correct_brackets($text)
    {
        $brackets_arr = str_split($text);
        $itog = 0;
        $result = true;

        foreach ($brackets_arr as $bracket) {
            $num = ($bracket == '(') ? 1 : -1;
            $itog = $itog + $num;
            if ($itog < 0) {
                $result = false;
                break;
            }
        }

        if ($itog <> 0) {
            $result = false;
        }
        return $result;
    }



