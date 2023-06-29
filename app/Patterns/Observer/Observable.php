<?php
declare(strict_types=1);

namespace Observer;

use Observer;

interface Observable
{
    public function addObserver(Observer\ObserverInterface $observer);

    public function removeObserver(Observer\ObserverInterface $observer);

    public function notifyObservers(string $event, $data = null);
}
