<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Storage\Redis;

class RedisStorageException extends \Exception
{
    private const CANNOT_GET_KEYS_OF_EVENTS = 1;
    private const CANNOT_GET_KEYS_OF_CONDITIONS = 2;
    private const CANNOT_GET_EVENT_DATA = 3;
    private const CANNOT_SET_EVENT_DATA = 4;
    private const CANNOT_ADD_EVENT_TO_SET = 5;
    private const CANNOT_DELETE_KEY = 6;

    public static function cannotGetKeysOfEvents(): self
    {
        return new self('Cannot get keys of events', self::CANNOT_GET_KEYS_OF_EVENTS);
    }

    public static function cannotGetKeysOfConditions(): self
    {
        return new self('Cannot get keys of conditions', self::CANNOT_GET_KEYS_OF_CONDITIONS);
    }

    public static function cannotGetEventData(string $event): self
    {
        return new self("Cannot get event '$event' data", self::CANNOT_GET_EVENT_DATA);
    }

    public static function cannotSetEventData(string $event): self
    {
        return new self("Cannot set event '$event' hash", self::CANNOT_SET_EVENT_DATA);
    }

    public static function cannotAddEventToSet(string $eventName, string $getConditionNameFromEvent): self
    {
        return new self("Cannot add event '$eventName' to set '$getConditionNameFromEvent'", self::CANNOT_ADD_EVENT_TO_SET);
    }

    public static function cannotDeleteKey(string $key): self
    {
        return new self("Cannot delete key '$key'", self::CANNOT_DELETE_KEY);
    }
}
