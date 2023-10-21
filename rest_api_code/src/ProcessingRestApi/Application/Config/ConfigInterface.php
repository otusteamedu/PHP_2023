<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\Config;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\Dto\Config;

interface ConfigInterface
{
    public function getAllSettings(): Config;
}
