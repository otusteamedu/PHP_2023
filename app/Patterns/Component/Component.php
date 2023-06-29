<?php
declare(strict_types=1);

use Component\Composite;
use Component\Leaf;

$leaf1 = new Leaf("Leaf 1");
$leaf2 = new Leaf("Leaf 2");
$leaf3 = new Leaf("Leaf 3");

$composite1 = new Composite("Composite 1");
$composite1->add($leaf1);
$composite1->add($leaf2);

$composite2 = new Composite("Composite 2");
$composite2->add($leaf3);

$composite1->add($composite2);

$composite1->operation();
