<?php

declare(strict_types=1);

function check_brackets($str): bool
{
    $open_bracket_count = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $char = $str[$i];
        if ($char == '(') {
            $open_bracket_count++;
        }

        if ($char == ')') {
            $open_bracket_count--;
        }

        if ($open_bracket_count < 0) {
            throw new Exception("Неожиданна закрывающая скобка, позиция: " . ($i + 1));
            return false;
        }
    }

    if ($open_bracket_count) {
        throw new Exception("Не хватает закрывающих скобок в количестве: " . $open_bracket_count . ' шт');
        return false;
    }

    return true;
}

try {
    if (!isset($_POST['string'])) {
        throw new Exception("Отсутсвует POST параметр string");
    }

    if (!($_POST['string'])) {
        throw new Exception("POST параметр string пустой");
    }

    $input_string = $_POST['string'];
    if (!check_brackets($input_string)) {
        throw new Exception("Ошибка проверки скобок");
    }

    echo "200 OK. Передан параметр \"$input_string\"";

} catch (Exception $e) {
    http_response_code(400);
    echo "400 Bad Request. " . $e->getMessage();
}
