<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;
use src\users\ru\AdminRu;
use tests\UserRoleTypesRu;

class UserImitation_admin_ru_Test extends TestCase
{
    public static function adminProvider() : array {
        return [
            [
                'whichUser' => UserRoleTypesRu::Admin(),
                'expectName' => (new AdminRu())->getName()
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
        $this->assertNotEquals($greeting, $user->getGreetingCaption());
    }

    #[DataProvider('adminProvider')]
    public function testGetCaptionName(string $admin, string $expectName)
    {
        $user = new UserImitation($admin);

        $this->assertEquals($admin, $user->getCaptionName());
        $this->assertNotEquals($expectName, $user->getCaptionName());
    }
}
