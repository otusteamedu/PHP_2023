<?php
declare(strict_types=1);

namespace Builder;

class Product
{
    private $part1;
    private $part2;

    public function setPart1($part1)
    {
        $this->part1 = $part1;
    }

    public function setPart2($part2)
    {
        $this->part2 = $part2;
    }

    public function getParts()
    {
        return "Part 1: " . $this->part1 . ", Part 2: " . $this->part2;
    }
}