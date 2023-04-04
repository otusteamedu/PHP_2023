<?php

declare(strict_types=1);

namespace Twent\Hw13\Exceptions\Config;

final class ConfigKeyDoesntExists extends \Exception
{
    protected $code = 400;

    public function __construct($key)
    {
        $this->message = "Запрашиваемый ключ конфигурации {$key} не найден!";

        parent::__construct($this->message, $this->code);
    }
}
