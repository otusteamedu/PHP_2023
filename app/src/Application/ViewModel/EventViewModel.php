<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\ViewModel;

final class EventViewModel
{
    public function __construct(
        public readonly int $priority,
        public readonly array $conditions,
        public readonly EventDataViewModel $data,
    ) {
    }
}
