<?php
declare(strict_types=1);

echo '<pre>';print_r($_SERVER);echo '</pre>';

$str = isset($_POST['string']) ? trim($_POST['string']) : '';
$error = '';
if (!empty($str)) {
    if ($str[0] == ')') {
        $error = 'Строка не может начинаться с закрытой скобки';
    } elseif ($str[mb_strlen($str)-1] == '(') {
        $error = 'Строка не может заканчиваться открытой скобкой';
    }
    $stack = $countOpen = $countClose = 0;
    for($i=0; $i<mb_strlen($str); $i++) {
        if ($str[$i] == '(') {
            $countOpen++;
            $stack++;
        } elseif ($str[$i] == ')') {
            $countClose++;
            $stack--;
        } else {
            $error = 'Строка не может содержать отличных от скобок символов';
            break;
        }
    }
} else {
    $error = 'Пустая строка';
}

if (empty($error)
    && ($countOpen != $countClose
        || $stack>0)
) {
    $error = 'Количество открытых скобок не равно количеству закрытых скобок';
}

$arReturn = [];
if (!empty($error)) {
    http_response_code(400);
    header('Content-type: application/json');
    $arReturn['error'] = $error;
} else {
    http_response_code(200);
    header('Content-type: application/json');
    $arReturn['success'] = 'Строка содержит корректное количество открытых и закрытых скобок';
}
echo json_encode($arReturn);
