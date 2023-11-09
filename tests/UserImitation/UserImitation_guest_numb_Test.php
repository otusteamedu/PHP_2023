<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;
use src\users\numb\GuestNumb;
use tests\UserRoleTypesNumb;

class UserImitation_guest_numb_Test extends TestCase
{
    public static function guestProvider() : array {
        return [
            ['whichUser' => UserRoleTypesNumb::Guest()]
        ];
    }

    #[DataProvider('guestProvider')]
    public function testGetGreetingCaption(string $guest)
    {
        $user = new UserImitation($guest);

        $this->assertNotEquals($guest, $user->getGreetingCaption());
        $this->assertNotEquals((new GuestNumb())->getName(), $user->getGreetingCaption());

        $greeting = 'Hello, '. (new GuestNumb())->getName() .'!';
        $this->assertEquals($greeting, $user->getGreetingCaption());
    }

    #[DataProvider('guestProvider')]
    public function testGetCaptionName(string $keyGuest)
    {
        $user = new UserImitation($keyGuest);

        $this->assertEquals((new GuestNumb())->getName(), $user->getCaptionName());
    }
}
