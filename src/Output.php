<?php

namespace src;

class Output
{
    public function toArray(?ListNode141 $node): array
    {
        $array = [];
        for (; $node; $node = $node->next) {
            $array[] = $node->val;
        }
        return $array;
    }
}
