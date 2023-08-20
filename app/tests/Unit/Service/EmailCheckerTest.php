<?php

namespace App\Tests\Unit\Service;

use App\Service\EmailChecker;
use Exception;
use PHPUnit\Framework\TestCase;

class EmailCheckerTest extends TestCase
{
    /**
     * @dataProvider successDataProvider
     */
    public function testEmailCheckerSuccess(string $email): void
    {
        $emailChecker = new EmailChecker();

        $result = true;

        try {
            $emailChecker->isEmailValid($email);
        } catch (Exception) {
            $result = false;
        }

        $this->assertEquals(true, $result);
    }

    /**
     * @dataProvider failureDataProvider
     */
    public function testEmailCheckerFailure(string $email): void
    {
        $emailChecker = new EmailChecker();

        $result = true;

        try {
            $emailChecker->isEmailValid($email);
        } catch (Exception) {
            $result = false;
        }

        $this->assertEquals(false, $result);
    }

    public function successDataProvider(): array
    {
        return [
            ["иван@тест.рф"],
            ["dclo@us.ibm.com"],
            ["customer/department=shipping@example.com"],
            ["!def!xyz%abc@example.com"],
            ["_somename@example.com"],
            ["user+mailbox@example.com"],
            ["peter.piper@example.com"],
        ];
    }

    public function failureDataProvider(): array
    {
        return [
            ["иван@тест=.рф"],
            ["иван@тест..рф"],
            ["@example.com"],
            ["local@"],
            ["example.com"],
            ["abc@def@example.com"],
            [".dot@example.com"],
            ["dot.@example.com"],
            ["two..dot@example.com"],
            ["hello world@example.com"],
            ["gatsby@f.sc.ot.t.f.i.tzg.era.l.d."],
        ];
    }
}
