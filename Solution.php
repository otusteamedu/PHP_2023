<?php

declare(strict_types=1);

function getIntersectionNode($headA, $headB)
{
    $pointer1 = $headA;
    $pointer2 = $headB;

    while (
        ($pointer1 !== $pointer2)
        && ($pointer1->next !== $pointer2->next)
    ) {
        $pointer1 = (!empty($pointer1->next)) ? $pointer1->next : $headB;
        $pointer2 = (!empty($pointer2->next)) ? $pointer2->next : $headA;
    }

    return ($pointer1 === $pointer2) ? $pointer1 : $pointer1->next;
}
