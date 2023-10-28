<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\Dto;

class Config
{
    public ?string $DBMSName;
    public ?string $connectionDbHost;
    public ?string $connectionDbPort;
    public ?string $connectionDbName;
    public ?string $connectionDbUser;
    public ?string $connectionDbPassword;

    public ?string $rabbitConnectionHostName;
    public ?string $rabbitConnectionPort;
    public ?string $rabbitConnectionUser;
    public ?string $rabbitConnectionassword;
}
