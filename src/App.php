<?php

declare(strict_types=1);

namespace App;

use App\Console\Input;
use App\Console\Output;
use App\Service\ElasticSearchService;

class App
{
    public function run(): void
    {
        $config = new Config();

        $input = new Input(getopt('q:c:l:'));

        $elasticService = new ElasticSearchService($config);

        $output = new Output();

        $result = $elasticService->search($input);
        $output->printResult($result);
    }
}
