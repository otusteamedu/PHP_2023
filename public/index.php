<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Elastic\Elasticsearch\ClientBuilder;
use App\MyApp;

try {
    $env = parse_ini_file(__DIR__ . '/../.env');

    $bulkFileData = $env['BULK_FILE'];
    $configIndex = $env['CONFIG_INDEX'];
    $params = require_once __DIR__ . "/../config/{$configIndex}";

    $url = $env['URL'];
    $user = $env['ELASTIC_USER'];
    $password = $env['ELASTIC_PASSWORD'];

    $client = ClientBuilder::create()
        ->setHosts([$url])
        ->setBasicAuthentication($user, $password)
        ->build();
    $response = $client->indices()->exists(['index' => $params['index']]);

    // Создаем индекс, если его еще нет
    if ($response->getStatusCode() != 200) {
        $client->indices()->create($params);
        shell_exec("curl --location --request POST '{$url}/_bulk' --header 'Content-Type: application/json' --data-binary '@data/{$bulkFileData}'");
    }

    $myApp = new MyApp($client, $params['index']);
    $result = $myApp->search(); // Поиск по переданным аргументам
    print_r($result);
} catch (Throwable $th) {
    print_r($th->getMessage());
}
