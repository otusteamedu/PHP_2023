<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Application\Config;

interface ConfigInterface
{
    public function getAllSettings(): array;
}
