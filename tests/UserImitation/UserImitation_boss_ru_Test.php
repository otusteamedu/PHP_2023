<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;
use src\users\ru\BossRu;
use tests\UserRoleTypesRu;

class UserImitation_boss_ru_Test extends TestCase
{
    public static function bossProvider() : array {
        return [
            ['whichUser' => UserRoleTypesRu::Boos()]
        ];
    }

    #[DataProvider('bossProvider')]
    public function testGetGreetingCaption(string $boss)
    {
        $user = new UserImitation($boss);

        $this->assertNotEquals($boss, $user->getGreetingCaption());
        $this->assertNotEquals(BossRu::nameDefault, $user->getGreetingCaption());

        $greeting = 'Hello, '. BossRu::nameDefault .'!';
        $this->assertNotEquals($greeting, $user->getGreetingCaption());
    }

    #[DataProvider('bossProvider')]
    public function testGetCaptionName(string $boss)
    {
        $user = new UserImitation($boss);

        $this->assertEquals($boss, $user->getCaptionName());
        $this->assertNotEquals(BossRu::nameDefault, $user->getCaptionName());
    }
}
