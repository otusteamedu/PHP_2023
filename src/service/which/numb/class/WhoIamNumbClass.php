<?php

namespace src\service\which\numb\class;

use src\interface\RoleUserInterface;

class WhoIamNumbClass implements RoleUserInterface {
    private const GUEST = 1;
    private const MGR   = 2;
    private const BOSS  = 3;
    private const ADMIN = 4;
    private const USER  = 5;
    private const EMPEROR  = 6;

    public static function Guest(): string {
        return self::GUEST;
    }

    public static function Mgr(): string {
        return self::MGR;
    }

    public static function Boos(): string {
        return self::BOSS;
    }

    public static function Admin(): string {
        return self::ADMIN;
    }

    public static function User(): string {
        return self::USER;
    }

    public static function Emperor(): string {
        return self::EMPEROR;
    }
}
