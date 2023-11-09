<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;

class UserImitation_user_Test extends TestCase
{
    public static function userProvider() : array {
        $nameRandom = 'Garry Potter';
        return [
            ['whichUser' => $nameRandom]
        ];
    }

    #[DataProvider('userProvider')]
    public function testGetGreetingCaption(string $who)
    {
        $user = new UserImitation($who);

        $this->assertNotEquals($who, $user->getGreetingCaption());

        $greeting = 'Hello, '. $who .'!';
        $this->assertEquals($greeting, $user->getGreetingCaption());
    }

    #[DataProvider('userProvider')]
    public function testGetCaptionName(string $who)
    {
        $user = new UserImitation($who);

        $this->assertEquals($who, $user->getCaptionName());
    }
}
