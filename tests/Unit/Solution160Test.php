<?php

namespace tests\Unit;

use Codeception\PHPUnit\TestCase;
use src\problem160\ListNode;
use src\problem160\Solution;
use Tests\Support\UnitTester;

class Solution160Test extends TestCase
{
    protected UnitTester $tester;

    public function testExample1(): void
    {
        $solution = new Solution();

        $el1_of_list1 = new ListNode(4, null);
        $el2_of_list1 = new ListNode(1, null);
        $el3_of_list1 = new ListNode(8, null); //*
        $el4_of_list1 = new ListNode(4, null);
        $el5_of_list1 = new ListNode(5, null);
        $el1_of_list1->next = $el2_of_list1;
        $el2_of_list1->next = $el3_of_list1;
        $el3_of_list1->next = $el4_of_list1;
        $el4_of_list1->next = $el5_of_list1;

        $el1_of_list2 = new ListNode(5, null);
        $el2_of_list2 = new ListNode(6, null);
        $el3_of_list2 = new ListNode(1, null);
        $el4_of_list2 = new ListNode(8, null);
        $el5_of_list2 = new ListNode(4, null);
        $el6_of_list2 = new ListNode(5, null);
        $el1_of_list2->next = $el2_of_list2;
        $el2_of_list2->next = $el3_of_list2;
        $el3_of_list2->next = $el3_of_list1;
        //$el3_of_list2->next = $el4_of_list2;
        //$el4_of_list2->next = $el5_of_list2;
        //$el5_of_list2->next = $el6_of_list2;

        $result = $solution->getIntersectionNode($el1_of_list1, $el1_of_list2);
        $this->assertNotNull($result);

        $this->assertSame(8, $result->val);
        $this->assertSame(4, $result->next->val);
        $this->assertSame(5, $result->next->next->val);
        $this->assertNull($result->next->next->next);
    }

    public function testExample2(): void
    {
        $solution = new Solution();

        $el1_of_list1 = new ListNode(1, null);
        $el2_of_list1 = new ListNode(9, null);
        $el3_of_list1 = new ListNode(1, null);
        $el4_of_list1 = new ListNode(2, null);//*
        $el5_of_list1 = new ListNode(4, null);
        $el1_of_list1->next = $el2_of_list1;
        $el2_of_list1->next = $el3_of_list1;
        $el3_of_list1->next = $el4_of_list1;
        $el4_of_list1->next = $el5_of_list1;


        $el1_of_list2 = new ListNode(3, null);
        $el2_of_list2 = new ListNode(2, null);
        $el3_of_list2 = new ListNode(4, null);
        //$el1_of_list2->next = $el1_of_list2;
        //$el2_of_list2->next = $el3_of_list2;
        $el1_of_list2->next = $el4_of_list1;


        $result = $solution->getIntersectionNode($el1_of_list1, $el1_of_list2);
        $this->assertNotNull($result);

        $this->assertSame(2, $result->val);
        $this->assertSame(4, $result->next->val);
        $this->assertNull($result->next->next);

        $this->assertNotSame($el1_of_list1, $result);
        $this->assertNotSame($el2_of_list1, $result);
        $this->assertNotSame($el3_of_list1, $result);
        $this->assertSame($el4_of_list1, $result);
        $this->assertNotSame($el5_of_list1, $result);

        $this->assertNotSame($el1_of_list2, $result);
        $this->assertNotSame($el2_of_list2, $result);
        $this->assertNotSame($el3_of_list2, $result);
    }

    public function testExample3(): void
    {
        $solution = new Solution();

        $el1_of_list1 = new ListNode(2, null);
        $el2_of_list1 = new ListNode(6, null);
        $el3_of_list1 = new ListNode(4, null);
        $el1_of_list1->next = $el2_of_list1;
        $el2_of_list1->next = $el3_of_list1;


        $el1_of_list2 = new ListNode(1, null);
        $el2_of_list2 = new ListNode(5, null);
        $el1_of_list2->next = $el2_of_list2;

        $result = $solution->getIntersectionNode($el1_of_list1, $el1_of_list2);
        $this->assertNull($result);
    }
}
