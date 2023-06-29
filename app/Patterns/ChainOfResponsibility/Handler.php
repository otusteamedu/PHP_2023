<?php
declare(strict_types=1);

namespace ChainOfResponsibility;

interface Handler
{
    public function setNext(Handler $nextHandler);

    public function handleRequest($request);
}
