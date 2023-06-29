<?php
declare(strict_types=1);

use ChainOfResponsibility\ConcreteHandlerA;
use ChainOfResponsibility\ConcreteHandlerB;

$handlerA = new ConcreteHandlerA();
$handlerB = new ConcreteHandlerB();

$handlerA->setNext($handlerB);

$handlerA->handleRequest('A');

$handlerA->handleRequest('B');


$handlerA->handleRequest('C');
