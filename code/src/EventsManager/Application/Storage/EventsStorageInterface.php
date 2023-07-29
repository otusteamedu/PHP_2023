<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Application\Storage;

use VKorabelnikov\Hw15\EventsManager\Domain\Model\Event;

interface EventsStorageInterface
{
    public function getByCondition(array $arConditions): string;
    public function add(Event $event): void;
    public function deleteAll(): void;
}
