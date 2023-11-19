<?php

declare(strict_types=1);

namespace VladimirPetrov\OtusStringHelper;
/**
 * Class for work specific string
 */
class StringHelper
{
    /**
     * Преобразовать в CamelCase
     * @param string $string
     * @return array|string|string[]|null
     */
    public static function explodeCamelCase(string $string)
    {
        return preg_replace('/([а-я])([А-Я])/u', '$1 $2', $string);
    }

    /**
     * Преобразовать string представление числа в float
     * @param string $val
     * @return float
     */
    public static function clearFloatVal(string $val): float
    {
        $val = str_replace(',', '.', $val);
        $val = str_replace(' ', '', $val);

        return floatval(preg_replace("/[^-0-9.]/", "", $val));
    }

}
