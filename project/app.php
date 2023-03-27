<?php

declare(strict_types=1);

use Vp\App\App;
use Vp\App\Config;
use Vp\App\Services\CommandProcessor;
use Elastic\Elasticsearch\ClientBuilder;

require_once('vendor/autoload.php');



$client = ClientBuilder::create()
    ->setHosts(['elasticsearch:9200'])
    ->setBasicAuthentication('elastic', 'pavlenko')
    ->build();

// Info API
$response = $client->info();

echo PHP_EOL;
echo $response['version']['number'];
echo PHP_EOL;
echo PHP_EOL;

//try {
//    Config::setConfig(parse_ini_file("config.ini", false, INI_SCANNER_TYPED));
//    $app = new App(new CommandProcessor());
//    $app->run($_SERVER['argv']);
//} catch (Exception $e) {
//    fwrite(STDOUT, "Error: " . $e->getMessage() . PHP_EOL);
//}
