<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw12\EventsManager\Storage;

abstract class EventsStorage {
    abstract public function getByCondition(array $arConditions): string;
    abstract public function add(array $arEventProps): void;
    abstract public function deleteAll(): void;
}
