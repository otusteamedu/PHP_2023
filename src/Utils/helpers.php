<?php

declare(strict_types=1);

/**
 * Convert Objects to Array
 */
function toArray($obj)
{
    if (is_object($obj)) {
        $obj = (array) $obj;
    }

    // If is array, make recursive call on every element
    if (is_array($obj)) {
        $newArray = [];

        foreach ($obj as $key => $val) {
            if (is_string($val) && empty($val)) {
                continue;
            }

            $keyContainsClassName = preg_match('/^\x00.*?\x00(.+)/', (string) $key, $matches);

            if ($keyContainsClassName) {
                $key = $matches[1];
            }

            if ($val instanceof DateTimeImmutable) {
                $val = $val->format('d-m-Y H:i:s');
            }

            $newArray[$key] = toArray($val);
        }

        return $newArray;
    }

    return $obj;
}
