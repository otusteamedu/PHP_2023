<?php

namespace Sva\App\Exceptions;

class UnknownMode extends \Exception
{
    public function __construct($mode)
    {
        $message = '\'' . $mode . '\' - Не известный метод запуска приложения';
        parent::__construct($message);
    }
}