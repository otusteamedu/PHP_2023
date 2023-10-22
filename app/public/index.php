<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Application\UseCase\{
    SearchByTitleCategory
};
use App\Infrastructure\Repository\InElasticSearchBookRepository;
use App\Application\UseCase\SearchByTitle;
use App\Application\UseCase\SearchByTitleCategoryPrice;
use App\Application\UseCase\SearchByTitleCategoryPriceAvailability;

try {
    $data = $_ENV['BULK_FILE'];
    $index = $_ENV['CONFIG_INDEX'];
    $params = require_once __DIR__ . "/../config/{$index}";

    $url = $_ENV['URL'];
    $user = $_ENV['ELASTIC_USER'];
    $password = $_ENV['ELASTIC_PASSWORD'];

    $repository = new InElasticSearchBookRepository($url, $user, $password, $params['index']);
    $response = $repository->client->indices()->exists(['index' => $params['index']]);

    // Создаем индекс, если его еще нет
    if ($response->getStatusCode() != 200) {
        $repository->client->indices()->create($params);
        shell_exec("curl --location --request POST '{$url}/_bulk' --header 'Content-Type: application/json' --data-binary '@data/{$data}'");
    }

    $args = $_SERVER['argv'];
    $countArgv = count($args);

    switch ($countArgv) {
        // Поиск по title -> php public/index.php гроницы
        case 2:
            $useCase = new SearchByTitle($repository);
            print_r($useCase($args[1]));
            break;

        // Поиск по title и строгому соответствую категории category -> php public/index.php гроницы "Любовный роман"
        case 3:
            $useCase = new SearchByTitleCategory($repository);
            print_r($useCase($args[1], $args[2]));
            break;

        // Поиск по title, строгому соответствую категории category и ценой <=|>= указанной ->
        // php public/index.php гроницы "Любовный роман" \>=9700
        case 4:
            $useCase = new SearchByTitleCategoryPrice($repository);
            print_r($useCase($args[1], $args[2], $args[3]));
            break;

        // php public/index.php Штирлиц "Исторический роман" \>=700 1
        // последний аргумент может быть любым, говорит о том, чтобы товар был в наличии
        case 5:
            $useCase = new SearchByTitleCategoryPriceAvailability($repository);
            print_r($useCase($args[1], $args[2], $args[3]));
            break;

        default:
            throw new Exception("Incorrect args");
    }
} catch (Throwable $th) {
    print_r($th->getMessage());
}
