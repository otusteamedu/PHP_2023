<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Application\Dto;

class Config
{
    public ?string $redisConnectionScheme;
    public ?string $redisConnectionHost;
    public ?string $redisConnectionPort;
}
