<?php

declare(strict_types=1);

/**
 * @param string $str
 * @return bool
 *
 * @throws Exception
 */
function isBracketsValid(string $str): true
{
    if (empty($str)) {
        throw new Exception('Введена пустая строка!');
    }
    if (!preg_match('/^[()]+$/', $str)) {
        throw new Exception('Строка должна содержать только символы скобок!');
    }

    $diff = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $diff = $str[$i] === '(' ? ++$diff : --$diff;
        if ($diff < 0) {
            throw new Exception("Закрывающая скобка в позиции $i не сочетается ни с одной открывающейся!");
        }
    }

    if ($diff !== 0) {
        throw new Exception("Открывающих скобок больше, чем закрывающих!");
    }

    return true;
}

if (isset($_POST['string'])) {
    try {
        isBracketsValid($_POST['string']);
        echo 'Строка из скобок валидна :)';
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
} else {
    echo 'Введена пустая строка!';
}
?>

<br>
<a href="index.php">На главную</a>
