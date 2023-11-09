<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;
use src\users\numb\BossNumb;
use tests\UserRoleTypesNumb;

class UserImitation_boss_numb_Test extends TestCase
{
    public static function bossProvider() : array {
        return [
            ['whichUser' => UserRoleTypesNumb::Boos()]
        ];
    }

    #[DataProvider('bossProvider')]
    public function testGetGreetingCaption(string $boss)
    {
        $user = new UserImitation($boss);

        $this->assertNotEquals($boss, $user->getGreetingCaption());
        $this->assertNotEquals((new BossNumb())->getName(), $user->getGreetingCaption());

        $greeting = 'Hello, '. (new BossNumb())->getName() .'!';
        $this->assertEquals($greeting, $user->getGreetingCaption());
    }

    #[DataProvider('bossProvider')]
    public function testGetCaptionName(string $keyBoss)
    {
        $user = new UserImitation($keyBoss);

        $this->assertEquals((new BossNumb())->getName(), $user->getCaptionName());
    }
}
