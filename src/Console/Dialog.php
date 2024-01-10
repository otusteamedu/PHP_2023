<?php

declare(strict_types=1);

namespace App\Console;

use App\Config;
use App\Service\ElasticSearchService;

class Dialog
{
    private Input $input;
    private Output $output;

    public function __construct()
    {
        $this->input = new Input(getopt('q:c:l:'));
        $this->output = new Output();
    }

    public function execute(): void
    {
        $searchParameters = $this->input->getSearchParameters();

        $config = new Config();
        $elasticService = new ElasticSearchService($config);

        $result = $elasticService->search($searchParameters);
        $this->output->printResult($result, ['title', 'category', 'price']);
    }
}
