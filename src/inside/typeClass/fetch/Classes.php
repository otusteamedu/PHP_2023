<?php

namespace src\inside\typeClass\fetch;

use src\inside\typeClass\IntClass;
use src\inside\typeClass\StringClass;

class Classes {
    public static function fetch(): array {
        return [
            IntClass::class => IntClass::build(),
            StringClass::class => StringClass::build(),
        ];
    }
}
