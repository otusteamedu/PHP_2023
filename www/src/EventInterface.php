<?php

declare(strict_types=1);

namespace Yalanskiy\HomeworkRedis;

/**
 * EventInterface
 */
interface EventInterface
{
    /**
     * Serialize Event object to string
     *
     * @return string
     */
    public function serialize(): string;

    /**
     * Create Event object from string
     *
     * @param string $eventString
     *
     * @return mixed
     */
    public static function createFromString(string $eventString): EventInterface;

    /**
     * Return Event object as formatted view
     *
     * @return string
     */
    public function print(): string;
}
