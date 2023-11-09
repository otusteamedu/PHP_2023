<?php

namespace src\service\link;

use src\inside\typeClass\StringClass;

class RoleLink
{
    public static function detect(StringClass $roleOrName, array $role2key): StringClass
    {
        return StringClass::build()->from(
          match(true) {
            self::isUserOrEmperor($roleOrName, $role2key) =>
                self::isEmperorRole($roleOrName) ?
                    'emperor' :
                    'user',
            default => $roleOrName->get() //@todo UserOrEmperor
        });
    }

    private static function isUserOrEmperor(StringClass $roleOrName, array $role2key): bool
    {
        return !array_key_exists($roleOrName->get(), $role2key); //@fixme
    }

    private static function isEmperorRole(StringClass $roleOrName): bool
    {
        return EmperorLink::has($roleOrName);
    }
}
