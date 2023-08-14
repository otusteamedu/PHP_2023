<?php

declare(strict_types=1);

namespace Root\App;

use DateTime;
use ReflectionEnum;
use ReflectionException;

class TypeHelper
{
    const DATETIME_FORMAT_TIMESTAMP = 'Y-m-d H:i:s.u';

    /**
     * @throws AppException
     */
    public static function toDatetime(DateTime|string|null $in): ?DateTime
    {
        if ($in instanceof DateTime) {
            return $in;
        } elseif (is_string($in)) {
            $date = DateTime::createFromFormat(self::DATETIME_FORMAT_TIMESTAMP, $in);
            if ($date === false) {
                /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
                throw new AppException("Error convert string to date ({$in})");
            }
            return $date;
        }
        return null;
    }

    /**
     * @throws AppException
     */
    public static function toEnum($param, $objectOrClass)
    {
        if ($param === null) {
            return null;
        }

        try {
            $reflection = new ReflectionEnum($objectOrClass);
            if (is_object($param) && $reflection->isInstance($param)) {
                return $param;
            }
            return $reflection->getCase($param)->getValue();
        } catch (ReflectionException $e) {
            /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
            throw new AppException("Error convert value `{$param}` to enum `{$objectOrClass}`. " .
                $e->getMessage());
        }
    }
}
