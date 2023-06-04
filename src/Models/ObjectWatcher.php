<?php

use Models\Movie;

class ObjectWatcher
{
    public $all;
    private static $instance = null;

    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function globalKey($object): string
    {
        $key = get_class($object) . '.' . $object->getId();
        return $key;
    }

    public static function add($object): void
    {
        $instance = self::instance();
        $instance->all[$instance->globalKey($object)] = $object;
    }

    public static function exists($className, $id)
    {
        $instance = self::instance();
        $key = "{$className}.$id";

        if(isset($instance->all[$key])) {
            return $instance->all[$key];
        }

        return null;
    }

}