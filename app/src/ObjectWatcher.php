<?php

declare(strict_types=1);

namespace App;

class ObjectWatcher
{
    /**
     * @var ObjectWatcher
     */
    private static $_instance;

    /**
     * @var array
     */
    private $objects = array();

    /**
     * @return ObjectWatcher
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new ObjectWatcher();
        }
        return self::$_instance;
    }

    /**
     * @param string $key
     * @return @mixed
     */
    public static function getRecord($key)
    {
        $inst = self::getInstance();
        if (isset($inst->objects[$key])) {
            return $inst->objects[$key];
        }
        return null;
    }
    /**
     * @param $obj
     *@param int $id
    */
    public static function addRecord($key, $obj)
    {
        $inst = self::getInstance();
        $inst->objects[$key] = $obj;
    }
}
