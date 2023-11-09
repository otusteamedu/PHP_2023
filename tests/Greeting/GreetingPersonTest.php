<?php

namespace tests\Greeting;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use src\greeting\GreetingPerson;

class GreetingPersonTest extends TestCase {
    public static function dataProvider() {
        $data = [
            ['Kesha', 'Hello, Kesha!'],
            ['Larisa Ivanovna', 'Hello, Larisa Ivanovna!'],
            //['admin', 'Hello, admin!'], //guest , admin, boss, ..
        ];

        return $data;
    }

    #[DataProvider('dataProvider')]
    public function testGetCaption(string $name, string $expectGreeting) {
        //$greeting = sprintf("Hello, %s!", $name);
        $person = new GreetingPerson();
        $this->assertEquals($expectGreeting, $person->getCaption($name));
    }
}
