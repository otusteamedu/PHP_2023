<?php

namespace src\service\which\enum;

use src\interface\RoleUserInterface;

class FacadeEnum implements RoleUserInterface
{
    public static function Guest(): string
    {
        return WhoIamEnum::Guest();
    }

    public static function Mgr(): string
    {
        return WhoIamEnum::Mgr();
    }

    public static function Boos(): string
    {
        return WhoIamEnum::Boos();
    }

    public static function Admin(): string
    {
        return WhoIamEnum::Admin();
    }

    public static function Emperor(): string
    {
        return WhoIamEnum::Emperor();
    }

    public static function User(): string
    {
        return WhoIamEnum::User();
    }
}
