<?php

//echo PHP_VERSION_ID;
echo PHP_VERSION;
//echo 123;
// phpinfo();

echo '<br/>';
print_r($_ENV);
echo '<br/>';
var_export($_SERVER);
echo '<br/>';

print_r(getenv());
echo '<br/>';

putenv('app_version=c3224e0');

echo '<br/>';

print_r(getenv());
echo '<br/>';
