<?php
declare(strict_types=1);

namespace ChainOfResponsibility;

class ConcreteHandlerA implements Handler
{
    private $nextHandler;

    public function setNext(Handler $nextHandler)
    {
        $this->nextHandler = $nextHandler;
    }

    public function handleRequest($request)
    {
        if ($request == 'A') {
            echo "ConcreteHandlerA: Handling the request." . PHP_EOL;
        } elseif ($this->nextHandler != null) {
            echo "ConcreteHandlerA: Passing the request to the next handler." . PHP_EOL;
            $this->nextHandler->handleRequest($request);
        } else {
            echo "ConcreteHandlerA: Cannot handle the request." . PHP_EOL;
        }
    }
}
