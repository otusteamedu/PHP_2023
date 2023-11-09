<?php

namespace src\extern\inputStaticStructure;

use src\interface\FetchableArrayInterface;

class LinkStaticArrayData implements FetchableArrayInterface
{
    public function fetch(): array
    {
        return [
            1 => ['src\users\numb\GuestNumb', 'aliases' => ['guest', 'гость', ''], 'active' => 1],
            //'гость' => ['src\users\ru\GuestRu', 'active' => false],

            2 => ['src\users\numb\ManagerNumb', 'aliases' => ['manager'], 'active' => 1],
            //'менеджер' => ['src\users\ru\ManagerRu'],

            3 => ['src\users\numb\BossNumb', 'aliases' => ['boss'], 'active' => 1],
            //'босс' => ['src\users\ru\BossRu', 'active' => false],

            4 => ['src\users\numb\AdminNumb', 'aliases' => ['admin'], 'active' => 1],
            //'админ' => ['src\users\ru\AdminRu'],

            6 => ['src\users\numb\EmperorNumb', 'with_name'=>'+', 'aliases' => ['emperor'], 'active' => 1],

            5 => ['src\users\numb\UserNumb', 'with_name'=>'+', 'aliases' => ['user'], 'active' => 1],
        ];
    }
}
