<?php

require __DIR__ . '/../vendor/autoload.php';

$generator = new MariaKvaskova\OtusComposer\PasswordGenerator();
echo $generator->create(15);
