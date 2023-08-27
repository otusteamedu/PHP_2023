<?php

declare(strict_types=1);

namespace Art\Php2023\Domain;

class PropertyIdentityMap
{
    /**
     * @var array
     */
    private static array $estates = [];

    /**
     * @param int $id
     * @return Property|null
     */
    public static function getProperty(int $id): ?Property
    {
        return self::$estates[$id] ?? null;
    }

    /**
     * @param Property $property
     * @return void
     */
    public static function addProperty(Property $property): void
    {
        self::$estates[$property->id] = $property;
    }

    /**
     * @return array
     */
    public static function getAllEstates(): array
    {
        return self::$estates;
    }
}
