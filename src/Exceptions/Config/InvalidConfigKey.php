<?php

declare(strict_types=1);

namespace Twent\Hw13\Exceptions\Config;

final class InvalidConfigKey extends \Exception
{
    protected $code = 400;
    protected $message = 'Передайте параметр для получения значения';
}
