<?php

namespace tests;

use src\interface\RoleUserInterface;

class UserRoleTypesRu implements RoleUserInterface {
    private const GUEST = 'гость';
    private const MGR   = 'менеджер';
    private const BOSS  = 'босс';
    private const ADMIN = 'админ';
    private const USER  = 'пользватель';
    private const EMPEROR  = 'император';

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
