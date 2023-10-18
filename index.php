<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Predis\Client;

$client = new Client();
$client->set('foo', '111');
$value = $client->get('foo');
