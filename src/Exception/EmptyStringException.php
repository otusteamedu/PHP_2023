<?php

namespace Pzagainov\Balancer\Exception;

class EmptyStringException extends \Exception
{
    protected $code = 400;
    protected $message = 'Empty string';
}
