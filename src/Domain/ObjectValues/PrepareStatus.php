<?php

declare(strict_types=1);

namespace User\Php2023\Domain\ObjectValues;

enum PrepareStatus: int {
    case IN_QUEUE = 0;
    case COOKING = 1;
    case FINISHED = 2;
    case DEFECTIVE = 3;

    public function getStatusName(): string {
        return match($this) {
            self::IN_QUEUE => 'В очереди',
            self::COOKING => 'Готовится',
            self::FINISHED => 'Готово',
            self::DEFECTIVE => 'Брак',
        };
    }
}
