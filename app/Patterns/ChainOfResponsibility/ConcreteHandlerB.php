<?php
declare(strict_types=1);

namespace ChainOfResponsibility;

class ConcreteHandlerB implements Handler
{
    private $nextHandler;

    public function setNext(Handler $nextHandler)
    {
        $this->nextHandler = $nextHandler;
    }

    public function handleRequest($request)
    {
        if ($request == 'B') {
            echo "ConcreteHandlerB: Handling the request." . PHP_EOL;
        } elseif ($this->nextHandler != null) {
            echo "ConcreteHandlerB: Passing the request to the next handler." . PHP_EOL;
            $this->nextHandler->handleRequest($request);
        } else {
            echo "ConcreteHandlerB: Cannot handle the request." . PHP_EOL;
        }
    }
}
