<?php

class Solution {
    /**
     * сложность O(n) - нет вложенных циклов,
     * сложность будет расти линейно при увеличении количества узлов в списке
     *
     * @param $head
     * @return bool
     */
    function hasCycle($head): bool
    {
        $fastNode = $head;

        while ($fastNode and $fastNode->next) {
            $head = $head->next;
            $fastNode = $fastNode->next->next;

            if ($head === $fastNode) {
                return true;
            }
        }

        return false;
    }
}