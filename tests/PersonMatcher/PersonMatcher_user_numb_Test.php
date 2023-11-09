<?php

namespace tests\PersonMatcher;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\inside\typeClass\StringClass;
use src\interface\NameableUserInterface;
use src\service\which\numb\PersonMatcherNumb;
use src\users\numb\UserNumb;
use tests\UserRoleTypesNumb;

class PersonMatcher_user_numb_Test extends TestCase
{
    public static function userProvider() : array {
        $randomNameUser = 'user-name';
        return [
            [
                'person' =>
                    (new PersonMatcherNumb(
                        new UserRoleTypesNumb()
                    ))
                        ->setName(StringClass::cast($randomNameUser))
                        ->match(StringClass::cast('user')),
                'randomNameUser' => $randomNameUser
            ]
        ];
    }

    #[DataProvider('userProvider')]
    public function testMatch(NameableUserInterface $user, string $nameUser)
    {
        $this->assertInstanceOf(UserNumb::class, $user);
    }

    #[DataProvider('userProvider')]
    public function testMatch_User_name(NameableUserInterface $user, string $nameUser)
    {
       $this->assertEquals($nameUser, $user->getName());
    }
}
