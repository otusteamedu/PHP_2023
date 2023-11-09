<?php

namespace tests\PersonMatcher;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\inside\typeClass\StringClass;
use src\interface\RoleUserInterface;
use src\service\which\numb\PersonMatcherNumb;
use src\users\numb\EmperorNumb;
use tests\UserRoleTypesNumb;

class PersonMatcher_emperor_numb_Test extends TestCase
{
    public static function emperorProvider() : array {
        return [
            [
                'randomName' => 'Gaius Iulius Caesar',
                'role' => 'emperor',
                'userType' => new UserRoleTypesNumb()
            ],
        ];
    }

    #[DataProvider('emperorProvider')]
    public function testMatch(string $emperorUser, string $role, RoleUserInterface $userType)
    {
        $user = (new PersonMatcherNumb($userType))
            ->setName(StringClass::cast($emperorUser))
            ->match(StringClass::cast($role));

        $this->assertInstanceOf(EmperorNumb::class, $user);
    }

    #[DataProvider('emperorProvider')]
    public function testMatch_Emperor_name(string $emperorUser, string $role, RoleUserInterface $userType)
    {
        $user = (new PersonMatcherNumb($userType))
            ->setName(StringClass::cast($emperorUser))
            ->match(StringClass::cast($role));

        $this->assertEquals($emperorUser, $user->getName());
    }
}
