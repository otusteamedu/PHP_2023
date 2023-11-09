<?php

namespace src\interface;

interface RoleUserInterface { //@fixme is role or key
    public static function Guest(): string;
    public static function Mgr(): string;
    public static function Boos(): string;
    public static function Admin(): string;
    public static function Emperor(): string;
    public static function User(): string;
}
