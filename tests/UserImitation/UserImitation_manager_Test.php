<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;
use src\users\Manager;
use tests\UserRoleTypes;

class UserImitation_manager_Test extends TestCase
{
    public static function managerProvider() : array {
        return [
            ['whichUser' => UserRoleTypes::Mgr()]
        ];
    }

    #[DataProvider('managerProvider')]
    public function testGetGreetingCaption(string $manager)
    {
        $user = new UserImitation($manager);

        $this->assertNotEquals($manager, $user->getGreetingCaption());
        $this->assertNotEquals(Manager::nameDefault, $user->getGreetingCaption());

        $greeting = 'Hello, '. Manager::nameDefault .'!';
        $this->assertEquals($greeting, $user->getGreetingCaption());
    }

    #[DataProvider('managerProvider')]
    public function testGetCaptionName(string $manager)
    {
        $user = new UserImitation($manager);

        $this->assertSame($manager, $user->getCaptionName());
        $this->assertSame((new Manager())->getName(), $user->getCaptionName());
    }
}
