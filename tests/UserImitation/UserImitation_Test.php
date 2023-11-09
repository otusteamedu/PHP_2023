<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;

class UserImitation_Test extends TestCase
{
    public static function userProvider() : array {
        return [
            [
                'whichUser' => 'Garry Potter',
                'expectName' => 'Garry Potter',
                'expectGreeting' => 'Hello, Garry Potter!'
            ],

            [
                'whichUser' => 'admin', //@fixme use not const
                'expectName' => 'admin',
                'expectGreeting' => 'Hello, admin!'
            ],

            [
                'whichUser' => 'guest',
                'expectName' => 'guest',//noname-guest | unknown
                'expectGreeting' => 'Hello, guest!'
            ],

            [
                'whichUser' => 'Gaius Iulius Caesar',
                'expectName' => 'Gaius Iulius Caesar', // `Caesar`
                'expectGreeting' => 'Ave, Csr'
            ],

            [
                'whichUser' => 'гость',
                'expectName' => 'guest', //noname-guest | unknown - it is Role in System (like alias),
                'expectGreeting' => 'Hello, guest!' // @fixme Приветствуем, гость!
            ],

//            [
//                'whichUser' => 'гость',
//                'expectName' => 'гость',//noname-guest | unknown
//                'expectGreeting' => 'Приветствуем, гость!'
//            ],

            [
                'whichUser' => '',
                'expect' => 'guest', //noname-guest | unknown
                'expectGreeting' => 'Hello, guest!'
            ],
        ];
    }

    #[DataProvider('userProvider')]
    public function testGetGreetingCaption(string $who, string $expect, string $expectGreeting)
    {
        $user = new UserImitation($who);

        $this->assertNotEmpty($expect);
        $this->assertEquals($expect, $user->getCaptionName()); //name|role ->whoami

        $this->assertNotEquals($who, $user->getGreetingCaption());

        //$greeting = 'Hello, '. $who .'!';//@fixme think how to test that (rule make)!
        $this->assertEquals($expectGreeting, $user->getGreetingCaption());
    }
}
