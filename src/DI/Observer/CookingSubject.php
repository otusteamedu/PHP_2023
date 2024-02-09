<?php

namespace HW11\Elastic\DI\Observer;

// Наблюдатель
abstract class CookingSubject implements Observer
{
    private array  $observers = [];
    private string $status;
    /**
     * @param \HW11\Elastic\DI\Observer\Observer $observer
     * @return void
     */
    public function addObserver(Observer $observer): void
    {
        $this->observers[] = $observer;
    }
    /**
     * @param string $status
     * @return void
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
        $this->notifyObservers();
    }
    /**
     * @return void
     */
    private function notifyObservers(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this->status);
        }
    }
}
