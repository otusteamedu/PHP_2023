<?php

namespace src;

require_once 'exceptionHandler.php';

use Exception;
use src\Exception\IoC;
use src\factory\CreatorService;
use src\inside\typeClass\StringClass;
use src\interface\CreatorServiceInterface;

class UserImitation {
    private CreatorServiceInterface $creator;

    public function __construct(
        string $whoRoleOrName,
        CreatorServiceInterface $creatorService = new CreatorService()
    ) {
        $this->creator = $creatorService;
        $roleOrName = StringClass::build()->from($whoRoleOrName);
        $this->creator->setRoleOrName($roleOrName);
    }

    public function getCaptionName(): string {
        return $this->getCreator()->makePerson()->getName();
    }

    public function getGreetingCaption(): string {
        try {
            return $this->getCreator()->makeGreeting()->getCaption(
                $this->getCaptionName()
            );
        } catch (Exception $exception) {
            IoC::build()->matchCommand($exception::class)->do($exception);
            return '';
        }
    }

    private function getCreator(): CreatorServiceInterface {
        return $this->creator;
    }
}
