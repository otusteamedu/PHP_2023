<?php

namespace App\Infrastructure\DataMapper;

use ReflectionClass;
use ReflectionException;

trait SetEntityIdTrait
{
    /**
     * @throws ReflectionException
     */
    private static function setId(object $entity, int $id): void
    {
        $reflectionClass = new ReflectionClass($entity);
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, $id);
    }
}
