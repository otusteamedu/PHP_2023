<?php

namespace src\service\link;

use src\interface\GettableArrayInterface;
use src\service\linkToUserClass\ServiceWrapper;

class RoleToKeyLink implements GettableArrayInterface
{
    public static function get(): array
    {
        return (new ServiceWrapper())
            ->getLink2UserClass()
            ->includeAliases('key')
            ->getAcc();
    }
}
