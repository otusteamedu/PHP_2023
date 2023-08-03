<?php

declare(strict_types=1);

namespace VLebedev\BookShop\Console;

use VLebedev\BookShop\Exception\InputException;
use VLebedev\BookShop\Service\ServiceInterface;

class Dialog
{
    private Input $input;
    private Output $output;
    private array $commandList = ['Upload File Data', 'Get Document By Id', 'Search Documents'];

    public function __construct()
    {
        $this->input = new Input();
        $this->output = new Output();
    }

    /**
     * @throws InputException
     */
    public function start(ServiceInterface $service): void
    {
        echo 'Select command number:' . PHP_EOL;
        foreach ($this->commandList as $index => $command) {
            echo $index + 1 . '. ' . $command . PHP_EOL;
        }

        $command = $this->input->getCommand($this->commandList);

        match ($command) {
            0 => $result = $service->uploadFileData($this->input->getUploadFilePath()),
            1 => $result = $service->getById($this->input->getSearchByIdParams()),
            2 => $result = $service->search($this->input->getSearchParams())
        };
        $this->output->printResult($result);
    }
}
