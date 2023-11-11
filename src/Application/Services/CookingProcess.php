<?php

declare(strict_types=1);

namespace User\Php2023\Application\Services;

use Exception;
use User\Php2023\Domain\Interfaces\Food;
use User\Php2023\Domain\Interfaces\Observable;
use User\Php2023\Domain\Interfaces\Observer;
use User\Php2023\Domain\ObjectValues\PrepareStatus;

class CookingProcess implements Observable {
    private static ?CookingProcess $instance = null;
    private $observers = [];
    private int $status;
    public Food $food;

    private function __construct() {}
    public static function getInstance(): CookingProcess {
        if (self::$instance === null) {
            self::$instance = new CookingProcess();
        }
        return self::$instance;
    }
    public function attach(Observer $observer): void
    {
        $this->observers[] = $observer;
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this->food, $this->status);
        }
    }

    public function changeStatus($status): void
    {
        $this->status = $status;
        $this->notify();
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @throws Exception
     */
    public function cook(): void {
        $this->startCooking();
        $this->finishCooking();
    }

    private function startCooking(): void {
        $this->changeStatus(PrepareStatus::COOKING->value);
    }

    /**
     * @throws Exception
     */
    private function finishCooking(): void {
        $status = random_int(0, 1) ? PrepareStatus::FINISHED : PrepareStatus::DEFECTIVE;
        $this->changeStatus($status->value);
    }
}
