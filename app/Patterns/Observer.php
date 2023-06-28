<?php
declare(strict_types=1);

interface Observer
{
    public function update(string $event, object $emitter, $data = null);
}

interface Observable
{
    public function addObserver(Observer $observer);
    public function removeObserver(Observer $observer);
    public function notifyObservers(string $event, $data = null);
}

class ConcreteObserver implements Observer
{
    public function update(string $event, object $emitter, $data = null)
    {
        echo "Observer reacted to event '{$event}' with data '".json_encode($data)."'\n";
    }
}

class ConcreteObservable implements Observable
{
    private $observers = [];

    public function addObserver(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    public function removeObserver(Observer $observer)
    {
        $this->observers = array_filter($this->observers, function($registeredObserver) use ($observer) {
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

$observable = new ConcreteObservable();
$observable->addObserver(new ConcreteObserver());
$observable->doSomething();
