<?php

namespace tests\PersonMatcher;

use PHPUnit\Framework\TestCase;
use src\inside\typeClass\StringClass;
use src\service\which\numb\PersonMatcherNumb;
use src\users\numb\GuestNumb;
use tests\UserRoleTypesNumb;

class PersonMatcher_guest_numb_Test extends TestCase
{
    public function testMatch_Guest()
    {
        $typeUser = new UserRoleTypesNumb();
        $guest = (new PersonMatcherNumb($typeUser))
            ->match(StringClass::cast($typeUser::Guest()));

        $this->assertInstanceOf(GuestNumb::class, $guest);
    }
}
