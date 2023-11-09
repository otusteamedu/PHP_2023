<?php

namespace tests;

use src\interface\RoleUserInterface;

class UserRoleTypesNumb implements RoleUserInterface {
    private const GUEST = 1;
    private const MGR   = 2;
    private const BOSS  = 3;
    private const ADMIN = 4;
    private const USER  = 5;
    private const EMPEROR = 6;

    const LIST = [
        self:: GUEST => 'guest',
        self:: MGR => 'manager',
        self:: BOSS => 'boss',
        self:: ADMIN => 'admin',
        self:: USER => 'user',
        self:: EMPEROR => 'emperor',
    ];

    public static function Guest(): string {
        return self::LIST[self::GUEST];
    }

    public static function Mgr(): string {
        return self::LIST[self::MGR];
    }

    public static function Boos(): string {
        return self::LIST[self::BOSS];
    }

    public static function Admin(): string {
        return self::LIST[self::ADMIN];
    }

    public static function Emperor(): string {
        return self::LIST[self::EMPEROR];
    }

    public static function User(): string {
        return self::LIST[self::USER];
    }
}
