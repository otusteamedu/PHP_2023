<?php

declare(strict_types=1);

namespace Tests;

use Closure;
use Exception;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        //
    }

    public function assertThrowsException(Closure $closure, string $exception)
    {
        try {
            $closure();
            $this->fail("Колбэк не возвращает Exception!");
        } catch (AssertionFailedError $e) {
            throw $e;
        } catch (Exception $e) {
            $this->assertInstanceOf($exception, $e, "Возвращается Exception другого типа!");
        }
    }
}
