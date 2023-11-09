<?php

namespace src\service\which\enum;

use src\interface\RoleUserInterface;

enum WhoIamEnum : string implements RoleUserInterface
{
    case GUEST = 'guest';
    case MGR   = 'manager';
    case BOSS  = 'boss';
    case ADMIN = 'admin';
    case EMPEROR = 'emperor';
    case USER  = 'user';

    public static function Guest(): string
    {
        return self::GUEST->value;
    }

    public static function Mgr(): string
    {
        return self::MGR->value;
    }

    public static function Boos(): string
    {
        return self::BOSS->value;
    }

    public static function Admin(): string
    {
        return self::ADMIN->value;
    }

    public static function Emperor(): string
    {
        return self::EMPEROR->value;
    }

    public static function User(): string
    {
        return self::USER->value;
    }
}
