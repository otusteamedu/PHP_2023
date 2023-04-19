<?php

function stringify(): void
{
    $string = $_POST['string'] ?? '';
    $isEmpty = emptyValidate($string);
    if ($isEmpty) {
        sendErrorUser('Пустая строка. Все плохо');
    }
    $isEqual = bracketsValidate($string);

    if (!$isEqual) {
        sendErrorUser('Не равное количество скобок. Все плохо');
    }
    sendSuccessResponse('Все хорошо');
}
