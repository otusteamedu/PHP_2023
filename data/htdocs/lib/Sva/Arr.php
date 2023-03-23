<?php

namespace Sva;

use ArrayAccess;

class Arr
{
    /**
     * Determine whether the given value is array accessible.
     *
     * @param mixed $value
     * @return bool
     */
    public static function accessible($value): bool
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param ArrayAccess|array $array
     * @param string|int|null $key
     * @return mixed
     */
    public static function get($array, $key)
    {
        if (is_null($key)) {
            return $array;
        }

        if (static::exists($array, $key)) {
            return $array[$key];
        }

        if (stripos($key, '.') === false) {
            return $array[$key] ?? null;
        }

        foreach (explode('.', $key) as $segment) {
            if (static::accessible($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return null;
            }
        }

        return $array;
    }

    /**
     * Determine if the given key exists in the provided array.
     *
     * @param ArrayAccess|array $array
     * @param string|int $key
     * @return bool
     */
    public static function exists($array, $key): bool
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        if (is_float($key)) {
            $key = (string)$key;
        }

        return array_key_exists($key, $array);
    }

    public static function buildTree(array $elements, $parentId = 0, $idKeyName = 'ID', $parentIdKeyName = 'PARENT_ID'): array
    {
        $branch = array();

        foreach ($elements as $element) {
            if (isset($element[$parentIdKeyName]) && $element[$parentIdKeyName] == $parentId) {
                $children = self::buildTree($elements, $element[$idKeyName], $idKeyName, $parentIdKeyName);
                if ($children) {
                    $element['CHILDREN'] = $children;
                }
                $branch[$element[$idKeyName]] = $element;
                unset($elements[$element[$idKeyName]]);
            }
        }
        return $branch;
    }
}
