<?php

namespace Shabanov\Otusphp\Services;

use Shabanov\Otusphp\Interfaces\ProductInterface;
use Shabanov\Otusphp\Decorator\MultipleIngradients;
use Shabanov\Otusphp\Observer\Event;

class Cooking
{
    private const STATUS_START = 'Оформлен';
    private const STATUS_PROCESS = 'У повара';
    private const STATUS_FINISH = 'К вам спешит курьер';
    private string $status;
    public function __construct(private ProductInterface $product,
                                private Event $event)
    {
        $this->setStatus(self::STATUS_START);
        //$this->addIngradients();
    }

    public function run()
    {
        sleep(1);
        $this->setStatus(self::STATUS_PROCESS);
        sleep(2);
        $this->setStatus(self::STATUS_FINISH);
    }

    /*
     * TODO Переделал на Builder
     * private function addIngradients()
    {
        $this->product = (new MultipleIngradients($this->product, $this->ingradients));
    }*/

    public function getStatus(): string
    {
        return $this->product->getInfo() . ' ' . $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        $this->event->notifySubscribers($this->product, $this->status);
        return $this;
    }

}
