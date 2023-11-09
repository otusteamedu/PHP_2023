<?php

namespace src\factory;

use src\greeting\create\MatchGreeting;
use src\inside\typeClass\IntClass;
use src\inside\typeClass\StringClass;
use src\interface\CreatorServiceInterface;
use src\interface\GreetingInterface;
use src\interface\NameableUserInterface;
use src\service\link\EmperorLink;

class CreatorService implements CreatorServiceInterface
{
    private StringClass $roleOrName;

    public function setRoleOrName(StringClass $whoRoleOrName): void
    {
        $this->roleOrName = $whoRoleOrName;
    }

    public function makeGreeting(): GreetingInterface
    {
        return MatchGreeting::create(IntClass::build()->fromInt(
            EmperorLink::has($this->roleOrName)
        ));
    }

    public function makePerson(): NameableUserInterface
    {
        return FactoryPersonNameable::create($this->roleOrName);
    }
}
