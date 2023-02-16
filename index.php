<?php
require_once './vendor/autoload.php';

$arr = [
    'success' => true
];

(new \Sva\Print\Arr())->print($arr);
