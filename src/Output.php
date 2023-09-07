<?php

namespace src;

class Output
{
    public function toArray(?ListNode $node): array
    {
        $array = [];
        for (; $node; $node = $node->next) {
            $array[] = $node->val;
        }
        return $array;
    }
}
