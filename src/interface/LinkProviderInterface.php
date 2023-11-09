<?php

namespace src\interface;

use src\inside\DTOPerson;

interface LinkProviderInterface {
    public function get(RoleUserInterface $typeUser,
                        DTOPerson $person): NameableUserInterface;
}
