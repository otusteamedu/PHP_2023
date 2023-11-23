<?php
declare(strict_types=1);


function get_brackets($text)
{
    $brackets = preg_replace("/[^\(\)]/i", '',$text);
    return $brackets;
}

function is_full($text="")
{
    if($text=="")
    {
        return true;
    }
    else
    {
        return false;
    }
}

function correct_brackets($text)
{
    $brackets_arr = str_split($text);
    $itog=0;
    $result = true;

    foreach ($brackets_arr as $bracket) {
        $num = ($bracket == '(') ? 1 : -1;
        $itog = $itog + $num;
        if ($itog < 0) {
            $result = false;
            break;
        }
    }

    if ($itog<>0) { $result = false; }
    return $result;
}


try {
    if (!isset($_POST['string'])){
        throw new Exception('Отсутствует параметр string');
    }

    $brack = get_brackets($_POST['string']);

    if (is_full($brack)){
        throw new Exception('В параметре string нет скобок');
    }

    if (!correct_brackets($brack)){
        throw new Exception('Некорректные скобки');
    }

    echo '200 Ok. В строке "'.$_POST['string'].'" скобки расставлены правильно' ;

} catch ( Exception $e){
    echo "400 Bad Request. ".$e->getMessage();
}

