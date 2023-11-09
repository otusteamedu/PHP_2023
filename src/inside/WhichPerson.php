<?php

namespace src\inside;

use src\inside\typeClass\StringClass;
use src\service\link\RoleLink;
use src\service\link\RoleToKeyLink;

class WhichPerson { //@fixme refactoring rename
    private StringClass $roleOrName;
    private DTOPerson $modelPerson;

    public function setAliasUser(StringClass $whoRoleOrName): self {
        $this->roleOrName = $whoRoleOrName;
        return $this;
    }

    public function takeAttributes(): self {
        $this->modelPerson = DTOPerson::build();
        $this->modelPerson->setRole($this->detectRole($this->roleOrName, $this->role2key()));
        $this->modelPerson->setKey($this->keyByRole($this->modelPerson->getRole()));
        $this->modelPerson->setName($this->roleOrName);
        return $this;
    }

    private function detectRole(StringClass $roleOrName, array $role2key): StringClass {
        return RoleLink::detect($roleOrName, $role2key);
    }

    private function keyByRole(StringClass $role): StringClass {
        return StringClass::build()->from(RoleToKeyLink::get()[$role->get()]);
    }

    private function role2key(): array {
        return RoleToKeyLink::get();
    }

    public function getName(): StringClass {
        return $this->modelPerson->getName();
    }

    public function getKey(): StringClass {
        return $this->modelPerson->getKey();
    }
}
