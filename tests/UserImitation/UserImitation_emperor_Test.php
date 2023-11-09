<?php

namespace tests\UserImitation;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\UserImitation;

class UserImitation_emperor_Test extends TestCase
{
    public static function emperorProvider() : array {
        $nameEmperor = 'Gaius Iulius Caesar'; // Гай Юлий Цезарь
        return [
            ['aliasUser' => $nameEmperor]
        ];
    }

    #[DataProvider('emperorProvider')]
    public function testGetGreetingCaption(string $who)
    {
        $user = new UserImitation($who);

        $this->assertNotEquals($who, $user->getGreetingCaption());

        $greeting = 'Ave, Csr';
        $this->assertEquals($greeting, $user->getGreetingCaption());
    }

    #[DataProvider('emperorProvider')]
    public function testGetCaptionName(string $who)
    {
        $user = new UserImitation($who);

        $this->assertEquals($who, $user->getCaptionName());
    }
}
