<?php

declare(strict_types=1);

namespace Twent\Hw13\Exceptions\Config;

final class InvalidConfigValue extends \Exception
{
    protected $code = 400;
    protected $message = 'Запрашиваемое значение должно быть строкой!';
}
