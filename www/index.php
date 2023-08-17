<?php

include "./vendor/autoload.php";

$measure = new \nalofree\utils\Pluar();
$count = 12;
echo($count . ' ' . $measure->getRu(12, ['негритёнок', 'негритёнка', 'негритят']));
