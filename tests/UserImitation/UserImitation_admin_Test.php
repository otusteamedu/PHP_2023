<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;
use src\users\Admin;
use tests\UserRoleTypes;

class UserImitation_admin_Test extends TestCase
{
    public static function adminProvider() : array {
        return [
            [
                'whichUser' => UserRoleTypes::Admin(),
                'expectName' => (new Admin())->getName()
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
    public function testGetCaptionName(string $admin, string $expectName)
    {
        $user = new UserImitation($admin);

        $this->assertEquals($admin, $user->getCaptionName());
        $this->assertEquals($expectName, $user->getCaptionName());
    }
}
