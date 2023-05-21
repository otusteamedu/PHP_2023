<?php

require '../vendor/autoload.php';

use Lujewwy\Capitalizer\Capitalizer;

echo Capitalizer::capitalize();
echo '<br />';
echo Capitalizer::capitalize('');
echo '<br />';
echo Capitalizer::capitalize('hello');
echo '<br />';
echo Capitalizer::capitalize('hello, world!');
echo '<br />';
echo Capitalizer::capitalize('1950 include require_once ABC123 aX12y Something ImPoRtAnT VERy MUCH');
echo '<br />';
echo Capitalizer::capitalize('😀 and something more SERIOUS - 👩‍👩‍👧');
echo '<br />';
