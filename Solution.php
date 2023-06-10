<?php

declare(strict_types=1);

namespace Solution;

class Solution
{
    /**
     * @param Integer $n
     * @return Integer
     */
    public function pivotInteger(int $n): int
    {
        for ($i = 1; $i <= $n; $i++) {
            if ($this->beforeN($i) == $this->afterN($i, $n)) {
                return $i;
            }
        }
        return -1;
    }

    private function beforeN(int $x): int
    {
        $result = 0;
        for ($i = 1; $i <= $x; $i++) {
            $result += $i;
        }
        return $result;
    }

    private function afterN(int $x, int $n): int
    {
        $result = 0;
        for ($i = $x; $i <= $n; $i++) {
            $result += $i;
        }
        return $result;
    }
}
