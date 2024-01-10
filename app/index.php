<?php

require_once __DIR__ . '/vendor/autoload.php';

use NdybnovHw03\CnfRead\ConfigStorage;


$config = (new ConfigStorage())
    ->fromDotEnvFile([__DIR__, '.env']);

$version = $config->get('APP_VERSION');
$comment = $config->get('COMMENT');

putenv('app_version=' . $version);
putenv('comment=' . $comment);

$version = sprintf(
    '%s:%s:%s',
    PHP_VERSION,
    getenv('app_version'),
    getenv('comment'),
);
echo $version;

var_dump($_ENV);


function dddddd(): int
{
    return 0;
}


class Dd {
    public function ddd(): int
    {
        return 0;
    }
}