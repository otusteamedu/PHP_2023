<?php
declare(strict_types=1);

namespace Observer;

use Observer;

class ConcreteObserverInterface implements Observer\ObserverInterface
{
    public function update(string $event, object $emitter, $data = null)
    {
        echo "Observer reacted to event '{$event}' with data '" . json_encode($data) . "'\n";
    }
}
