<?php

namespace tests;

use src\ListNode141;
use PHPUnit\Framework\TestCase;
use src\Output;
use src\Solution141;

class Solution141Test extends TestCase
{
    public function testHasCycle00()
    {
        $solution = new Solution141();

        $list1 = new ListNode141(1, null);

        $hasCycle = $solution->hasCycle($list1);

        $expect = false;
        $this->assertSame($expect, $hasCycle);
    }

    public function testHasCycle01()
    {
        $solution = new Solution141();

        $el1 = new ListNode141(1, null);
        $el2 = new ListNode141(3, null);
        $el1->next = $el2;
        $el2->next = $el1;

        $hasCycle = $solution->hasCycle($el1);

        $expect = true;
        $this->assertSame($expect, $hasCycle);
    }

    public function testHasCycle02()
    {
        $solution = new Solution141();

        $head = new ListNode141(
            3,
            null
        );
        $el2 = new ListNode141(
            2,
            null
        );
        $el3 = new ListNode141(
            0,
            null
        );
        $el4 = new ListNode141(
            -4,
            null
        );
        $head->next = $el2;
        $el2->next = $el3;
        $el3->next = $el4;
        $el4->next = $el2;

        $hasCycle = $solution->hasCycle($head);

        $expect = true;
        $this->assertSame($expect, $hasCycle);
    }

}

