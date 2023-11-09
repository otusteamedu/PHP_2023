<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;
use src\users\Guest;
use tests\UserRoleTypes;

class UserImitation_guest_Test extends TestCase
{
    public static function guestProvider() : array {
        return [
            ['whichUser' => UserRoleTypes::Guest()]
        ];
    }

    #[DataProvider('guestProvider')]
    public function testGetGreetingCaption(string $guest)
    {
        $user = new UserImitation($guest);

        $this->assertNotEquals($guest, $user->getGreetingCaption());
        $this->assertNotEquals(Guest::nameDefault, $user->getGreetingCaption());

        $greeting = 'Hello, '. Guest::nameDefault .'!';
        $this->assertEquals($greeting, $user->getGreetingCaption());
    }

    #[DataProvider('guestProvider')]
    public function testGetCaptionName(string $guest)
    {
        $user = new UserImitation($guest);

        $this->assertEquals($guest, $user->getCaptionName());
        $this->assertEquals(Guest::nameDefault, $user->getCaptionName());
    }
}
