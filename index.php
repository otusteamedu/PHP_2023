<?php

use src\UserImitation;

require_once 'vendor/autoload.php';
require_once 'src/lib/misc.php';


$user = new UserImitation('admin');

echo $user->getGreetingCaption();
$EOL = getEOL(is_cli());
echo $EOL;
