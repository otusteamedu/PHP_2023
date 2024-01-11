<?php

declare(strict_types=1);

namespace App\LinkedListCycle;

class LinkedListCycle
{
    public function hasCycle($head): bool
    {
        if ($head == null) {
            return false;
        }

        $fastNode = $head;

        while ($fastNode && $fastNode->next) {
            $head = $head->next;
            $fastNode = $fastNode->next->next;

            if ($fastNode === $head) {
                return true;
            }
        }

        return false;
    }
}
