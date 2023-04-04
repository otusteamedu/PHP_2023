<?php

declare(strict_types=1);

namespace Twent\Hw13\Exceptions\Config;

final class InvalidConfigFile extends \Exception
{
    protected $code = 400;

    public function __construct($filename)
    {
        $this->message = "Файл конфигурации {$filename} не валиден!";

        parent::__construct($this->message, $this->code);
    }
}
