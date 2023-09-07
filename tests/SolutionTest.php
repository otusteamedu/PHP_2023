<?php

namespace tests;

use src\ListNode;
use src\Output;
use src\Solution;
use PHPUnit\Framework\TestCase;

class SolutionTest extends TestCase
{
    public function testMergeTwoListsCase00()
    {
        //Input: list1 = [], list2 = [null]
        //Output: [null]
        $solution = new Solution();

        $list1 = null;
        $list2 = new ListNode(null, null);

        $list = $solution->mergeTwoLists($list1, $list2);

        $listArray = (new Output())->toArray($list);
        $this->assertIsArray($listArray);

        $expect = [null];
        $this->assertSame($expect, $listArray);
    }

    public function testMergeTwoListsCase01()
    {
        //Input: list1 = [1,2,4], list2 = [1,3,4]
        //Output: [1,1,2,3,4,4]
        $solution = new Solution();

        $list1 = new ListNode(1, new ListNode(2, new ListNode(4, null)));
        $list2 = new ListNode(1, new ListNode(3, new ListNode(4, null)));

        $list = $solution->mergeTwoLists($list1, $list2);

        $listArray = (new Output())->toArray($list);
        $this->assertIsArray($listArray);

        $expect = [1,1,2,3,4,4];
        $this->assertSame($expect, $listArray);
    }

    public function testMergeTwoListsCase02()
    {
        //Input: list1 = [5], list2 = [1,2,4]
        //Output: [1,2,4,5]
        $solution = new Solution();

        $list1 = new ListNode(5, null);
        $list2 = new ListNode(1, new ListNode(2, new ListNode(4, null)));

        $list = $solution->mergeTwoLists($list1, $list2);

        $listArray = (new Output())->toArray($list);
        $this->assertIsArray($listArray);

        $expect = [1,2,4,5];
        $this->assertSame($expect, $listArray);
    }

    public function testMergeTwoListsCase03()
    {
        //Input: list1 = [1], list2 = [2]
        //Output: [1,2]
        $solution = new Solution();

        $list1 = new ListNode(1, null);
        $list2 = new ListNode(2, null);

        $list = $solution->mergeTwoLists($list1, $list2);

        $listArray = (new Output())->toArray($list);
        $this->assertIsArray($listArray);

        $expect = [1,2];
        $this->assertSame($expect, $listArray);
    }

    public function testMergeTwoListsCase04()
    {
        //Input: list1 = [-9, 3], list2 = [5, 7]
        //Output: [-9,3,5,7]
        $solution = new Solution();

        $list1 = new ListNode(-9, new ListNode(3, null));
        $list2 = new ListNode(5, new ListNode(7, null));

        $list = $solution->mergeTwoLists($list1, $list2);

        $listArray = (new Output())->toArray($list);
        $this->assertIsArray($listArray);

        $expect = [-9,3,5,7];
        $this->assertSame($expect, $listArray);
    }

    public function testMergeTwoListsCase05()
    {
        //Input: list1 = [-10,-10,-9,-4,1,6,6], list2 = [-7]
        //Output: [-10,-10,-9,-7,-4,1,6,6]
        $solution = new Solution();

        $list1 = new ListNode(-10, new ListNode(-10, new ListNode(-9, new ListNode(-4, new ListNode(1, new ListNode(6, new ListNode(6, null)))))));
        $list2 = new ListNode(-7, null);

        $list = $solution->mergeTwoLists($list1, $list2);

        $listArray = (new Output())->toArray($list);
        $this->assertIsArray($listArray);

        $expect = [-10,-10,-9,-7,-4,1,6,6];
        $this->assertSame($expect, $listArray);
    }

    public function testMergeTwoListsCase06()
    {
        //Input: list1 = [-2,5], list2 = [-9,-6,-3,-1,1,6]
        //Output: [-9,-6,-3,-2,-1,1,5,6]
        $solution = new Solution();

        $list1 = new ListNode(-2, new ListNode(5, null));
        $list2 = new ListNode(-9, new ListNode(-6, new ListNode(-3, new ListNode(-1, new ListNode(1, new ListNode(6, null))))));

        $list = $solution->mergeTwoLists($list1, $list2);

        $listArray = (new Output())->toArray($list);
        $this->assertIsArray($listArray);

        $expect = [-9,-6,-3,-2,-1,1,5,6];
        $this->assertSame($expect, $listArray);
    }

    public function testMergeTwoListsCase06_2()
    {
        //Input: list1 = [-2,5], list2 = [-9,-6,-3,-1,1,6]
        //Output: [-9,-6,-3,-2,-1,1,5,6]
        $solution = new Solution();

        $list2 = new ListNode(-2, new ListNode(5, null));
        $list1 = new ListNode(-9, new ListNode(-6, new ListNode(-3, new ListNode(-1, new ListNode(1, new ListNode(6, null))))));

        $list = $solution->mergeTwoLists($list1, $list2);

        $listArray = (new Output())->toArray($list);
        $this->assertIsArray($listArray);

        $expect = [-9,-6,-3,-2,-1,1,5,6];
        $this->assertSame($expect, $listArray);
    }

    public function testMergeTwoListsCase07()
    {
        //Input: list1 = [-10,-9,-6,-4,1,9,9], list2 = [-5,-3,0,7,8,8]
        //Output: [-10,-9,-6,-5,-4,-3,0,1,7,8,8,9,9]
        $solution = new Solution();

        $list2 = new ListNode(-10, new ListNode(-9, new ListNode(-6, new ListNode(-4, new ListNode(1, new ListNode(9, new ListNode(9, null)))))));
        $list1 = new ListNode(-5, new ListNode(-3, new ListNode(0, new ListNode(7, new ListNode(8, new ListNode(8, null))))));

        $list = $solution->mergeTwoLists($list1, $list2);

        $listArray = (new Output())->toArray($list);
        $this->assertIsArray($listArray);

        $expect = [-10,-9,-6,-5,-4,-3,0,1,7,8,8,9,9];
        $this->assertSame($expect, $listArray);
    }
}
