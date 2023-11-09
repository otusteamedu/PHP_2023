<?php

namespace tests\PersonMatcher;

use PHPUnit\Framework\TestCase;
use src\inside\typeClass\StringClass;
use src\service\which\numb\PersonMatcherNumb;
use src\users\numb\ManagerNumb;
use tests\UserRoleTypesNumb;

class PersonMatcher_manager_numb_Test extends TestCase
{
    public function testMatch_Manager()
    {
        $typeUser = new UserRoleTypesNumb();
        $manager = (new PersonMatcherNumb($typeUser))
            ->match(StringClass::cast($typeUser::Mgr()));

        $this->assertInstanceOf(ManagerNumb::class, $manager);
    }
}
