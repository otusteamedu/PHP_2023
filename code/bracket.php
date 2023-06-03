<?php

declare(strict_types=1);

/**
 * @param string $str
 * @return bool
 *
 * @throws Exception
 */
function isValid(string $str): bool
{
    if (empty($str) || !preg_match('/^[()]+$/', $str)) {
        throw new Exception('Пустая строка или строка без скобок');
    }

    $bracketCount = substr_count($str, '(') == substr_count($str, ')') ? 'success': 'error';
    if($bracketCount === 'error') {
        http_response_code(400);
        throw new Exception("Количество открывающихся и закрывающихся скобок не соответствует- все плохо");
    }

    $stack = [];
    $newStr = "";

    foreach (str_split($str) as $val) {
        if($val == "(") {
            array_push($stack, $val);
        } else {
            if(empty($stack)) {
                break;
            } else {
                array_pop($stack);
            }
        }
        $newStr .= $val;
    }

    $bracketCountDiff = ($newStr == $str) && empty($stack) ? 'success': 'error';
    if($bracketCountDiff === 'error') {
        http_response_code(400);
        throw new Exception("Конструкция ')('- не допустима");
    }

    return true;
}

if (isset($_POST['brackets'])) {
    try {
        isValid($_POST['brackets']);
        echo 'Ошибок не найдено: количество скобок - валидно!';
        http_response_code(200);
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
} else {
    echo 'Введена пустая строка!';
}
?>

<br>
<a href="index.php">Назад</a>