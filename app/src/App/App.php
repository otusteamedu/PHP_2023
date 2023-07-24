<?php

declare(strict_types=1);

namespace DEsaulenko\Hw11\App;

use Desaulenko\Hw11\Elastic;
use Dotenv\Dotenv;

class App
{
    protected string $index;

    private string $q;
    private int $priceFrom;

    public function __construct()
    {
        $this->parseArgs();
        Dotenv::createUnsafeImmutable(realpath(__DIR__ . '/../../'))->load();
        $this->index = getenv('INDEX');
    }
    public function run(): void
    {
        $elasticController = new Elastic\Controller($this->index);
        $service = new Elastic\Service($elasticController);
        $service->searchByTitleAndPrice($this->q, $this->priceFrom);
    }

    protected function parseArgs(): void
    {
        global $argv;
        if (
            count($argv) < 3
        ) {
            throw new \Exception('Введите параметры: строка поиска и цена');
        }

        if (!$argv[1]) {
            throw new \Exception('Введите строку поиска');
        }

        if (!$argv[2]) {
            throw new \Exception('Введите цену');
        }

        $this->q = $argv[1];
        $this->priceFrom = (int)$argv[2];
    }
}
