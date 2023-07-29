<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Application\Storage;

use VKorabelnikov\Hw15\EventsManager\Domain\Model\Event;
use VKorabelnikov\Hw15\EventsManager\Domain\ValueObject\Priority;
use VKorabelnikov\Hw15\EventsManager\Domain\ValueObject\ConditionList;
use VKorabelnikov\Hw15\EventsManager\Domain\ValueObject\EventTitle;

interface EventsStorageInterface
{
    public function getByCondition(ConditionList $conditions): EventTitle;
    public function add(Event $event): void;
    public function deleteAll(): void;
}
