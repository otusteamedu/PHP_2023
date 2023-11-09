<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;
use src\users\numb\ManagerNumb;
use tests\UserRoleTypesNumb;

class UserImitation_manager_numb_Test extends TestCase
{
    public static function managerProvider() : array {
        return [
            ['whichUser' => UserRoleTypesNumb::Mgr()]
        ];
    }

    #[DataProvider('managerProvider')]
    public function testGetGreetingCaption(string $manager)
    {
        $user = new UserImitation($manager);

        $this->assertNotEquals($manager, $user->getGreetingCaption());
        $this->assertNotEquals((new ManagerNumb())->getName(), $user->getGreetingCaption());

        $greeting = 'Hello, '. (new ManagerNumb())->getName() .'!';
        $this->assertEquals($greeting, $user->getGreetingCaption());
    }

    #[DataProvider('managerProvider')]
    public function testGetCaptionName(string $keyManager)
    {
        $user = new UserImitation($keyManager);

        $this->assertSame((new ManagerNumb())->getName(), $user->getCaptionName());
    }
}
