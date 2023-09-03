<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Application\Config;

use VKorabelnikov\Hw16\MusicStreaming\Application\Dto\Config;

interface ConfigInterface
{
    public function getAllSettings(): Config;
}