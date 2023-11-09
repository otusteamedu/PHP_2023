<?php

namespace tests\PersonMatcher;

use PHPUnit\Framework\TestCase;
use src\inside\typeClass\StringClass;
use src\service\which\numb\PersonMatcherNumb;
use src\users\numb\AdminNumb;
use tests\UserRoleTypesNumb;

class PersonMatcher_admin_numb_Test extends TestCase
{
    public function testMatch()
    {
        $userType = new UserRoleTypesNumb();
        $admin = (new PersonMatcherNumb($userType))
            ->match(StringClass::cast($userType::Admin()));

        $this->assertInstanceOf(AdminNumb::class, $admin);
    }
}
