<?php

declare(strict_types=1);

namespace DShevchenko\Hw4;

require __DIR__ . '/cache.php';

use DShevchenko\Hw4\Cache;

class Validator
{
    public static function validateString(string $source): bool
    {
        // Подключаем memcached
        $cache = new cache('memcached', 11211);

        // Ищем строку в кэше
        $valueFromCache = $cache->get($source);
        if ($cache->valueFound()) {
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
            } elseif ($char === ')') {
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
}
