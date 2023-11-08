<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Controllers\Test;

class TestTest extends TestCase
{
    public function testGreetsWithName(): void
    {
        $test = new Test();
        $int = $test->test();
        $this->assertEquals(123, $int);
    }
}
