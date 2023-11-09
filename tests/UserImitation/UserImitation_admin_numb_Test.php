<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;
use src\users\numb\AdminNumb;
use tests\UserRoleTypesNumb;

class UserImitation_admin_numb_Test extends TestCase
{
    public static function adminProvider() : array {
        return [
            [
                'whichUser' => UserRoleTypesNumb::Admin(),
                'expectName' => (new AdminNumb())->getName()
            ],
        ];
    }

    #[DataProvider('adminProvider')]
    public function testGetGreetingCaption(string $admin, string $expectName)
    {
        $user = new UserImitation($admin);

        $this->assertNotEquals($admin, $user->getGreetingCaption());
        $this->assertNotEquals($expectName, $user->getGreetingCaption());

        $greeting = 'Hello, '. $expectName .'!';
        $this->assertEquals($greeting, $user->getGreetingCaption());
    }

    #[DataProvider('adminProvider')]
    public function testGetCaptionName(string $keyAdmin, string $expectName)
    {
        $user = new UserImitation($keyAdmin);

        $this->assertEquals($expectName, $user->getCaptionName());
    }
}
