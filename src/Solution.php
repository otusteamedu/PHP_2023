<?php

declare(strict_types=1);

namespace User\Php2023;

class Solution
{
    public function hasCycle(ListNode $head): bool
    {
        $hash = [];
        while ($head !== null) {
            $id = spl_object_id($head);
            if (isset($hash[$id])) {
                return true;
            }
            $hash[$id] = true;
            $head = $head->next;
        }
        return false;
    }
}
