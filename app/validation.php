<?php

declare(strict_types=1);

function validation(string $str)
{
    if (empty($str)) {
        throw new Exception('Введена пустая строка! Необходимо ввести символы скобок в поле');
    }
    if (!preg_match('/^[()]+$/', $str)) {
        throw new Exception('Строка должна содержать только символы скобок, ()');
    }

    $diff = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $diff = $str[$i] === '(' ? ++$diff : --$diff;
        if ($diff < 0) {
            throw new Exception("Закрывающая скобка в позиции $i не сочетается ни с открывающей!");
        }
    }

    if ($diff !== 0) {
        throw new Exception("Открывающих скобок больше, чем закрывающих!");
    }

    return true;
}

if (isset($_POST['string'])) {
    try {
        validation($_POST['string']);
        echo 'Валидация пройдена :)';
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
} else {
    echo 'Введена пустая строка!';
}
?>

<br>
<a href="index.php">Еще один шанс</a>
