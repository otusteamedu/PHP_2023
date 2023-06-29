<?php
declare(strict_types=1);

namespace Observer;
use ConcreteObservable;
use Observer;


$observable = new ConcreteObservable();
$observable->addObserver(new Observer\ConcreteObserverInterface());
$observable->doSomething();
