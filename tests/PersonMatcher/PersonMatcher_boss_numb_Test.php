<?php

namespace tests\PersonMatcher;

use PHPUnit\Framework\TestCase;
use src\inside\typeClass\StringClass;
use src\service\which\numb\PersonMatcherNumb;
use src\users\numb\BossNumb;
use tests\UserRoleTypesNumb;

class PersonMatcher_boss_numb_Test extends TestCase
{
    public function testMatch_Boss()
    {
        $typeUser = new UserRoleTypesNumb();
        $boss = (new PersonMatcherNumb($typeUser))
            ->match(StringClass::cast($typeUser::Boos()));

        $this->assertInstanceOf(BossNumb::class, $boss);
    }
}
