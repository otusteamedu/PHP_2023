<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use src\Solution17;

class Solution17Test extends TestCase
{
    public function testletterCombinations00()
    {
        $input = "";
        $output = [];
        $solution = new Solution17();

        $list = $solution->letterCombinations($input);
        $this->assertSame($output, $list);
    }

    public function testletterCombinations01()
    {
        $input = "2";
        $output = [
            "a","b","c"
        ];
        $solution = new Solution17();

        $list = $solution->letterCombinations($input);
        $this->assertSame($output, $list);
    }

    public function testletterCombinations02()
    {
        $input = "23";
        $output = [
            "ad","ae","af",
            "bd","be","bf",
            "cd","ce","cf"
        ];
        $solution = new Solution17();

        $combinations = $solution->letterCombinations($input);
        $this->assertSame($output, $combinations);
    }

    public function testletterCombinations03()
    {
        $input = "22";
        $output = [
            "aa","ab","ac",
            "ba","bb","bc",
            "ca","cb","cc"
        ];
        $solution = new Solution17();

        $combinations = $solution->letterCombinations($input);
        $this->assertSame($output, $combinations);
    }

    public function testletterCombinations04()
    {
        $input = "234";
        $output = [
            "adg","adh","adi", "aeg","aeh","aei", "afg","afh","afi",
            "bdg","bdh","bdi", "beg","beh","bei", "bfg","bfh","bfi",
            "cdg","cdh","cdi", "ceg","ceh","cei", "cfg","cfh","cfi"
        ];
        $solution = new Solution17();

        $combinations = $solution->letterCombinations($input);
        $this->assertSame($output, $combinations);
    }
}
