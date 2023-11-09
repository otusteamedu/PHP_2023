<?php

namespace tests\Greeting;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\greeting\GreetingEmperor;

class GreetingEmperorTest extends TestCase {
    public static function dataProvider() {
        $data = [
            //['Caesar', 'Ave, Csr!'],
            ['Gaius Iulius Caesar', 'Ave, Csr'],
            //['admin', 'Hello, admin!'], //guest , admin, boss, ..
        ];

        return $data;
    }

    #[DataProvider('dataProvider')]
    public function testGetCaption(string $name, string $expectGreeting) {
        $person = new GreetingEmperor();
        $this->assertEquals($expectGreeting, $person->getCaption($name));
    }
}
