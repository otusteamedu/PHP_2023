<?php

namespace src\interface;

use src\inside\typeClass\StringClass;

interface CreatorServiceInterface
{
    public function setRoleOrName(StringClass $whoRoleOrName);

    public function makeGreeting(): GreetingInterface;

    public function makePerson(): NameableUserInterface;
}
