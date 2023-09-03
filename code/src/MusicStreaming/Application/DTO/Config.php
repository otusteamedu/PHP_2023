<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\Dto;

class Config
{
    public ?string $DBMSName;
    public ?string $connectionDbHost;
    public ?string $connectionDbPort;
    public ?string $connectionDbName;
    public ?string $connectionDbUser;
    public ?string $connectionDbPassword;
}