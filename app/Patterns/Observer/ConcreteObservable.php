<?php
declare(strict_types=1);

class ConcreteObservable implements Observer\Observable
{
    private $observers = [];

    public function addObserver(Observer\ObserverInterface $observer)
    {
        $this->observers[] = $observer;
    }

    public function removeObserver(Observer\ObserverInterface $observer)
    {
        $this->observers = array_filter($this->observers, function ($registeredObserver) use ($observer) {
            return $registeredObserver !== $observer;
        });
    }

    public function notifyObservers(string $event, $data = null)
    {
        foreach ($this->observers as $observer) {
            $observer->update($event, $this, $data);
        }
    }

    public function doSomething()
    {
        echo 'Bake a cookie!';

        $this->notifyObservers('somethingHappened', ['data' => 123]);
    }
}
