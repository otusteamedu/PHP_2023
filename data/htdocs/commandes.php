<?php

use Sva\Common\Domain\Node;

return [
    'default' => function () {
        $nodeA5 = new Node(5);
        $nodeA4 = new Node(4);
        $nodeA4->next = $nodeA5;
        $nodeA3 = new Node(3);
        $nodeA3->next = $nodeA4;
        $nodeA2 = new Node(2);
        $nodeA2->next = $nodeA3;
        $nodeA1 = new Node(1);
        $nodeA1->next = $nodeA2;


        $nodeB1 = new Node(16);
        $nodeB2 = new Node(18);
        $nodeB3 = new Node(18);

        $nodeB1->next = $nodeB2;
        $nodeB2->next = $nodeB3;
        $nodeB2->next = $nodeA3;

        \Sva\Common\App\LinkedListUtils::getIntersect($nodeA1, $nodeB1);
    }
];
