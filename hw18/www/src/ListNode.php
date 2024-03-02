<?php
declare(strict_types=1);

namespace Shabanov\Otusphp;
class ListNode
{
    public ?self $next = null;

    public function __construct(public int $val) {}

    public static function createFromArray(array $data): self
    {
        $head = new self($data[0]);
        $current = $head;
        unset($data[0]);

        foreach ($data as $i => $item) {
            $node = new self($item);
            $current->next = $node;
            $current = $current->next;
        }

        return $head;
    }

    public static function getIntersectionNode(self $head1, self $head2): ?self
    {
        while ($head2 != null) {
            $temp = $head1;
            while ($temp != null) {
                if ($temp === $head2) {
                    return $head2;
                }
                $temp = $temp->next;
            }
            $head2 = $head2->next;
        }
        return null;
    }
}
