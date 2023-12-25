<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\action\deleteIndices\ClearDataCommand;
use App\Application\action\titleCategoryPriceSearch\TitleCategoryPriceCriteria;
use App\Application\action\titleCategoryPriceSearch\TitleCategoryPriceSearchQuery;
use App\Application\action\titleSearch\TitleCriteria;
use App\Application\action\titleSearch\TitleSearchQuery;
use App\Application\adapter\AdapterInterface;
use App\Application\adapter\ClickHouseRepositoryResultForUITableAdapter;
use App\Application\adapter\ElasticSearchRepositoryResultForUITableAdapter;
use App\Application\config\ElasticSearchConfig;
use App\Application\resultUI\TableResult;
use App\Infrastructure\Repository\ClickHouseRepository;
use App\Infrastructure\Repository\ElasticSearchRepository;
use App\Infrastructure\Repository\RepositoryInterface;
use NdybnovHw03\CnfRead\Storage;

class AppSearch
{
    private Storage $config;
    private array $arguments;

    public function __construct(
        Storage $configStorage,
        array $arguments
    ) {
        $this->config = $configStorage;
        $this->arguments = $arguments;
    }

    public function run(): void
    {
        $useRepository = $this->config->get('USE_REPOSITORY');
        $repository = $this->getRepositoryByType($useRepository);

        if (!$repository->isDataValid()) {
            $repository->init();
            echo 'Repository updated!!!' . PHP_EOL;
        }

        $adapterForUITable = $this->getRepositoryResultForUITableAdapterByType($useRepository);
        $argv = $this->arguments;
        $searches = [
            // php public/index.php рыцОри
            2 => static function () use ($repository, $argv, $adapterForUITable): void {
                $query = new TitleSearchQuery($repository);
                $result = $query->search(new TitleCriteria($argv));
                $result = $adapterForUITable->convert($result);
                (new TableResult())->showTable($result);
            },

            // php public/index.php рыцОри clear
            3 => static function () use ($repository): void {
                $cleanCommand = new ClearDataCommand($repository);
                $cleanCommand->run();
            },

            //php public/index.php рыцОри "Исторический роман" \<=2000
            4 => static function () use ($repository, $argv, $adapterForUITable): void {
                $query = new TitleCategoryPriceSearchQuery($repository);
                $result = $query->search(new TitleCategoryPriceCriteria($argv));
                $result = $adapterForUITable->convert($result);
                (new TableResult())->showTable($result);
            },
        ];

        $countArgv = count($argv);
        if (!isset($searches[$countArgv])) {
            throw new \RuntimeException("Error: Unexpected arguments.");
        }
        $searches[$countArgv]();
        echo 'Done!!!' . PHP_EOL;
    }

    private function getRepositoryByType(string $type): RepositoryInterface
    {
        $config = $this->config;
        $matchRepository = match (true) {
            $this->isClickHouseType($type) =>
                ClickHouseRepository::class,
            $this->isElasticSearchType($type) =>
                ElasticSearchRepository::class,
        };

        return new $matchRepository($config);
    }

    private function getRepositoryResultForUITableAdapterByType(string $type): AdapterInterface
    {
        $matchAdapter = match (true) {
            $this->isClickHouseType($type) =>
                ClickHouseRepositoryResultForUITableAdapter::class,
            $this->isElasticSearchType($type) =>
                ElasticSearchRepositoryResultForUITableAdapter::class,
        };

        return new $matchAdapter();
    }

    private function isClickHouseType(string $type): bool
    {
        return in_array($type, ['clickhouse', 'ch']);
    }

    private function isElasticSearchType(string $type): bool
    {
        return in_array($type, ['elasticsearch', 'elastic', 'es']);
    }
}
