<?php

function getIntersectionNode($headA, $headB)
{
    $headA_ = $headA;
    $headB_ = $headB;
    $headALength = 0;
    $headBLength = 0;

    while ($headA_) {
        $headALength++;
        $headA_ = $headA_->next;
    }

    while ($headB_) {
        $headBLength++;
        $headB_ = $headB_->next;
    }

    if ($headALength > $headBLength) {
        $first = $headA;
        $second = $headB;
        $maxLength = $headALength;
        $minLength = $headBLength;
    } else {
        $first = $headB;
        $second = $headA;
        $maxLength = $headBLength;
        $minLength = $headALength;
    }

    for ($i = $minLength; $i < $maxLength; $i++) {
        $first = $first->next;
    }

    while ($first && $second) {
        if ($first === $second) {
            return $first;
        }

        $first = $first->next;
        $second = $second->next;
    }

    return null;
}
