<?php

namespace App\Models;

class Observable
{
    protected $observers = [];
    protected $status;

    public function addObserver(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->notifyObservers();
    }

    public function notifyObservers()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this->status);
        }
    }
}
