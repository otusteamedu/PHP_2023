<?php

declare(strict_types=1);

namespace DEsaulenko;

use DEsaulenko\Hw14\ListNode;

require_once('vendor/autoload.php');



/**
 * Сложность O(n)
 */
class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle(ListNode $head): bool
    {
        $nodes = [];
        $current = $head;
        while ($current->next !== null) {
            if (
                isset($nodes[$current->next->val])
                && $nodes[$current->next->val] === $current->next
            ) {
                return true;
            }
            $nodes[$current->val] = $current;
            $current = $current->next;
        }

        return false;
    }
}

function makeNodesList(array $head, $pos): array
{
    foreach ($head as $i => $item) {
        $node = new ListNode($item);
        $nodes[$i] = $node;
        if ($i <= 0) {
            continue;
        }
        $nodes[$i - 1]->next = $node;

        if (
            $i === count($head) - 1
            && $nodes[$pos]
        ) {
            $node->next = &$nodes[$pos];
        }

    }
    return $nodes;
}

$head = [3, 2, 0, -4];
$pos = 1;
$nodes = makeNodesList($head, $pos);
$solution = new Solution();
$r = $solution->hasCycle(current($nodes));
dump([$head, $pos, $r]);

$head = [1, 2];
$pos = 0;
$nodes = makeNodesList($head, $pos);
$solution = new Solution();
$r = $solution->hasCycle(current($nodes));
dump([$head, $pos, $r]);

$head = [1];
$pos = -1;
$nodes = makeNodesList($head, $pos);
$solution = new Solution();
$r = $solution->hasCycle(current($nodes));
dump([$head, $pos, $r]);

$head = [1, 2, 6, 7, 1, 4, 7, 10];
$pos = 3;
$nodes = makeNodesList($head, $pos);
$solution = new Solution();
$r = $solution->hasCycle(current($nodes));
dump([$head, $pos, $r]);

$head = [-21, 10, 17, 8, 4, 26, 5, 35, 33, -7, -16, 27, -12, 6, 29, -12, 5, 9, 20, 14, 14, 2, 13, -24, 21, 23, -21, 5];
$pos = -1;
$nodes = makeNodesList($head, $pos);
$solution = new Solution();
$r = $solution->hasCycle(current($nodes));
dump([$head, $pos, $r]);
