<?php

use Sva\Common\Domain\Node;

return [
    'default' => function () {

        $node = \Sva\Common\App\LinkedListUtils::createCycledLinkedList();
        echo (\Sva\Common\App\LinkedListUtils::hasCycle($node) ? 'true' : 'false') . "\n";
        $node = \Sva\Common\App\LinkedListUtils::createNonCycledLinkedList();
        echo (\Sva\Common\App\LinkedListUtils::hasCycle($node) ? 'true' : 'false') . "\n";
    }
];
