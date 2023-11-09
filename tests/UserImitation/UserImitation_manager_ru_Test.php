<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;
use src\users\ru\ManagerRu;
use tests\UserRoleTypesRu;

class UserImitation_manager_ru_Test extends TestCase
{
    public static function managerProvider() : array {
        return [
            ['whichUser' => UserRoleTypesRu::Mgr()]
        ];
    }

    #[DataProvider('managerProvider')]
    public function testGetGreetingCaption(string $manager)
    {
        $user = new UserImitation($manager);

        $this->assertNotEquals($manager, $user->getGreetingCaption());
        $this->assertNotEquals(ManagerRu::nameDefault, $user->getGreetingCaption());

        $greeting = 'Hello, '. ManagerRu::nameDefault .'!';
        $this->assertEquals($greeting, $user->getGreetingCaption());
    }

    #[DataProvider('managerProvider')]
    public function testGetCaptionName(string $manager)
    {
        $user = new UserImitation($manager);

        $this->assertSame($manager, $user->getCaptionName());
        $this->assertSame((new ManagerRu())->getName(), $user->getCaptionName());
    }
}
