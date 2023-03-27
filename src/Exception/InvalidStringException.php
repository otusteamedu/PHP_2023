<?php

namespace Pzagainov\Balancer\Exception;

class InvalidStringException extends \Exception
{
    protected $code = 400;
    protected $message = 'Empty string';
}
