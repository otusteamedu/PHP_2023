<?php

declare(strict_types=1);

namespace User\Php2023\Infrastructure\Cooking;

use Exception;
use User\Php2023\Application\Services\CookingProcess;
use User\Php2023\Domain\Interfaces\Food;
use User\Php2023\Domain\ObjectValues\PrepareStatus;

class CookingProxy {
    private CookingProcess $cookingProcess;

    public function __construct() {
        $this->cookingProcess = CookingProcess::getInstance();
    }

    /**
     * @throws Exception
     */
    public function cook(Food $item): void
    {
        $this->cookingProcess->cook($item);
    }

    public function getStatus(): PrepareStatus
    {
        return PrepareStatus::from($this->cookingProcess->getStatus());
    }
}
