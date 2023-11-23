<?php

declare(strict_types=1);

function validateString(string $source) : bool {
    
    $cache = new \Memcached;
    $cache->addServer('memcached', 11211); 

    // Ищем строку в кэше
    $valueFromCache = $cache->get($source);
    if ($cache->getResultCode() === \Memcached::RES_SUCCESS) {
        return $valueFromCache;
    }

    // Если нет в кэше - выполняем валидацию
    $counter = 0;
    $strLen = mb_strlen($source);
    $value = true;

    // Перебираем все символы строки и проверяем скобки
    for ($i = 0; $i < $strLen; $i++) {
        $char = mb_substr($source, $i, 1); 
        if ($char === '(') {
            $counter++;
        }
        elseif ($char === ')') {
            $counter--;
            // Если закрывается скобка, которую не открывали - проверка не пройдена
            if ($counter < 0) {
                $value = false;
                break;
            }
        }
    }

    // Если валидация не закончилась ошибкой при прошлой проверке - используем финальную проверку на соотвествие скобочек
    if ($value === true) {
        $value = ($counter === 0);
    }

    // Сохраняем результат валидации в кэш
    $cache->set($source, $value);

    return ($value);
}

// ---------------------

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        throw new Exception("Method Not Allowed. Please use the POST method.");
    }

    // Получаем payload
    $rawPayload = file_get_contents('php://input');

    if (empty($rawPayload)) {
        throw new Exception('Payload is empty.');
    }

    if (!validateString($rawPayload)) {
        throw new Exception('Validation failed.');
    }

    echo 'Validation successful.';

} catch (Exception $e) {
    // Устанавливаем код 400, если до этого не был установлен другой код
    if (http_response_code() === 200) {
        http_response_code(400);
    }
    echo $e->getMessage();
}


