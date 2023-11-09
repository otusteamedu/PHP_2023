<?php

namespace tests;

use src\interface\RoleUserInterface;

class UserRoleTypes implements RoleUserInterface {
    private const GUEST = 'guest';
    private const MGR   = 'manager';
    private const BOSS  = 'boss';
    private const ADMIN  = 'admin';
    private const USER  = 'user';
    private const EMPEROR = 'emperor';

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

    public static function Emperor(): string {
        return self::EMPEROR;
    }

    public static function User(): string {
        return self::USER;
    }
}
