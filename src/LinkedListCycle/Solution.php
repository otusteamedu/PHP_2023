<?php

declare(strict_types=1);

namespace App\LinkedListCycle;

final class Solution
{
    public static function hasCycle(ListNode $head): bool
    {
        if ($head->next !== null) {
            return false;
        }

        $hashes = [spl_object_hash($head)];
        $node = $head->next;
        while ($node !== null) {
            $hash = spl_object_hash($node);
            if (in_array($hash, $hashes, true)) {
                return true;
            }
            $hashes[] = $hash;
            $node = $node->next;
        }

        return false;
    }
}
