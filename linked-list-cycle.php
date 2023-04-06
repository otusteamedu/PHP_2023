<?php

declare(strict_types=1);

namespace Twent\Hw14;

class ListNode
{
    public $val = 0;
    public $next = null;

    public function __construct($val)
    {
        $this->val = $val;
    }
}

class LinkedList
{
    public $head;

    public function __construct()
    {
        $this->head = null;
    }
}

class SolutionWithSet
{
    public function hasCycle(?ListNode $head): bool
    {
        if (! $head || ! $head->next) {
            return false;
        }

        $nodesSeen = [];

        while ($head && $head->next) {
            if (in_array(spl_object_id($head), $nodesSeen)) {
                return true;
            }

            $nodesSeen[] = spl_object_id($head);
            $head = $head->next;
        }

        return false;
    }
}

class SecondSolution
{
    public function hasCycle(?ListNode $head): bool
    {
        if (! $head || ! $head->next) {
            return false;
        }

        return $this->check($head->next, $head->next->next);
    }

    public function check(?ListNode $current, ?ListNode $next): bool
    {
        if ($current === $next) {
            return true;
        }

        if (! $current->next || ! $next->next->next) {
            return false;
        }

        return $this->check($current->next, $next->next->next);
    }
}

class ThirdSolution
{
    public function hasCycle(?ListNode $head): bool
    {
        if (! $head || ! $head->next) {
            return false;
        }

        $current = $head;
        $next = $head->next;

        while ($next && $next->next) {
            if (! $current->next || ! $next->next->next) {
                return false;
            }

            if ($current === $next) {
                return true;
            }

            $current = $current->next;
            $next = $next->next->next;
        }

        return false;
    }
}
