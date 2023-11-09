<?php

namespace src\service\which\numb;

use src\factory\FactoryLinkProvider;
use src\inside\DTOPerson;
use src\inside\typeClass\StringClass;
use src\interface\NameableUserInterface;
use src\interface\RoleUserInterface;

class PersonMatcherNumb
{
    private RoleUserInterface $typeUser;
    private DTOPerson $dtoPerson;

    public function __construct(RoleUserInterface $typeUser)
    {
        $this->typeUser = $typeUser;
        $this->dtoPerson = DTOPerson::build();
    }

    public function setName(StringClass $name): self
    {
        $this->dtoPerson->setName($name);
        return $this;
    }

    public function match(StringClass $whoseKey): NameableUserInterface
    {
        return FactoryLinkProvider::create()
            ->get(
                $this->typeUser,
                $this->dtoPerson->setKey($whoseKey)
            );
    }
}
