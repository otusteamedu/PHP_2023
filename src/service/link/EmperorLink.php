<?php

namespace src\service\link;

use src\extern\EmperorNames;
use src\inside\typeClass\StringClass;

class EmperorLink
{
    public static function has(StringClass $role): bool
    {
        return in_array(
            $role->toString(),
            EmperorNames::fetch(),
            true
        );
    }
}
