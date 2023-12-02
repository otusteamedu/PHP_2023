<?php

namespace Dshevchenko\Emailchecker;

class Common
{
    /**
     * Разбивает исходные электронные письма на массив
     *
     * @param string $rawEmails
     * @return array
     */
    public static function explode(string $rawEmails): array
    {
        $cleanEmails = str_replace(["\r\n", "\n", "\r", "\t"], ' ', $rawEmails);
        $arrEmails = explode(' ', $cleanEmails);
        $arrEmails = array_filter($arrEmails);

        return $arrEmails;
    }

    /**
     * Преобразование имен для классов и методов в соответсвии с CamelCase
     *
     * @param string $name Исходное имя, которое требуется отформатировать.
     * @param bool $lowerFirst Опционально. Указывает, следует ли преобразовать первый символ в нижний регистр. По умолчанию равно false.
     *
     * @return string Возвращает обработанное и отформатированное имя.
     */
    public static function intoCamelCase(string $name, bool $lowerCamelCase = false): string
    {
        $renamed = strtolower($name);
        $renamed = str_replace('_', ' ', $renamed);
        $renamed = ucwords($renamed);
        $renamed = str_replace(' ', '', $renamed);

        if ($lowerCamelCase) {
            $renamed = lcfirst($renamed);
        }

        return $renamed;
    }
}
