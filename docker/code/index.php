<?php

use IilyukDmitryi\App;

require_once('vendor/autoload.php');

try {
    $app = new App\App();
    $app->run();
} catch (Exception $e) {
    echo '<pre>' . print_r([$e], 1) . '</pre>' . __FILE__ . ' # ' . __LINE__;//test_delete
    echo 'Exception ' . $e->getMessage();
}


return;



echo '<pre>' . print_r(['index . php'], 1) . '</pre>' . __FILE__ . ' # ' . __LINE__;//test_delete


require __DIR__ . "/vendor/autoload.php";

use Elastic\Elasticsearch\ClientBuilder;

// $test = file_get_contents('https://elastic:test@elasticsearch:9200');//gethostbyname("elasticsearch");
// var_dump($test);


$client = ClientBuilder::create()
    ->setHosts(['http://elastic:9200'])
    //->setBasicAuthentication('elastic', 'secret') // Пароль
   /// ->setCABundle('/data/mysite.local/http_ca.crt') // Сертификат
    ->build();


echo '<pre>' . print_r([$client->info()], 1) . '</pre>' . __FILE__ . ' # ' . __LINE__;//test_delete
/**/
