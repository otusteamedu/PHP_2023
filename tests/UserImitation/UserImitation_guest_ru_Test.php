<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;
use src\users\ru\GuestRu;
use tests\UserRoleTypesRu;

class UserImitation_guest_ru_Test extends TestCase
{
    public static function guestProvider() : array {
        return [
            ['whichUser' => UserRoleTypesRu::Guest()]
        ];
    }

    #[DataProvider('guestProvider')]
    public function testGetGreetingCaption(string $guest)
    {
        $user = new UserImitation($guest);

        $this->assertNotEquals($guest, $user->getGreetingCaption());
        $this->assertNotEquals(GuestRu::nameDefault, $user->getGreetingCaption());

        //$greeting = 'Hello, '. GuestRu::nameDefault .'!';
        $roleDefaultGuest = 'guest';
        $greeting = 'Hello, '. $roleDefaultGuest .'!';
        $this->assertEquals($greeting, $user->getGreetingCaption());
    }

    #[DataProvider('guestProvider')]
    public function testGetCaptionName(string $guest)
    {
        $user = new UserImitation($guest);

        $roleDefaultGuest = 'guest';
        $this->assertEquals($roleDefaultGuest, $user->getCaptionName());
        //$this->assertEquals($guest, $user->getCaptionName());
        //$this->assertEquals(GuestRu::nameDefault, $user->getCaptionName());
    }
}
