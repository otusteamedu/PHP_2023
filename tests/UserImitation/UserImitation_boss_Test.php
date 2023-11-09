<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;
use src\users\Boss;
use tests\UserRoleTypes;

class UserImitation_boss_Test extends TestCase
{
    public static function bossProvider() : array {
        return [
            ['whichUser' => UserRoleTypes::Boos()]
        ];
    }

    #[DataProvider('bossProvider')]
    public function testGetGreetingCaption(string $boss)
    {
        $user = new UserImitation($boss);

        $this->assertNotEquals($boss, $user->getGreetingCaption());
        $this->assertNotEquals(Boss::nameDefault, $user->getGreetingCaption());

        $greeting = 'Hello, '. Boss::nameDefault .'!';
        $this->assertEquals($greeting, $user->getGreetingCaption());
    }

    #[DataProvider('bossProvider')]
    public function testGetCaptionName(string $boss)
    {
        $user = new UserImitation($boss);

        $this->assertEquals($boss, $user->getCaptionName());
        $this->assertEquals(Boss::nameDefault, $user->getCaptionName());
    }
}
