<?php

use Radovinetch\Hw11\Bootstrap;

require 'vendor/autoload.php';

$options = getopt('c:q:p:');

$bootstrap = new Bootstrap();
$bootstrap->init($options);