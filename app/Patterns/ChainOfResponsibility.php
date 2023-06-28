<?php
declare(strict_types=1);


interface Handler
{
    public function setNext(Handler $nextHandler);

    public function handleRequest($request);
}

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

$handlerA = new ConcreteHandlerA();
$handlerB = new ConcreteHandlerB();

$handlerA->setNext($handlerB);

$handlerA->handleRequest('A');

$handlerA->handleRequest('B');


$handlerA->handleRequest('C');



