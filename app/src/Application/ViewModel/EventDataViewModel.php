<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\ViewModel;

final class EventDataViewModel
{
    public function __construct(
        public readonly string $type,
        public readonly string $name,
        public readonly string $dateTime,
    ) {
    }
}
