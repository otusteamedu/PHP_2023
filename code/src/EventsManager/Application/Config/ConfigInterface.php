<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Application\Config;

use VKorabelnikov\Hw15\EventsManager\Application\Dto\Config;

interface ConfigInterface
{
    public function getAllSettings(): Config;
}
