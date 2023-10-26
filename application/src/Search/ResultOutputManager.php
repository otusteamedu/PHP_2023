<?php

namespace Gesparo\ES\Search;

use Gesparo\ES\OutputHelper;

class ResultOutputManager
{
    private const MASK = "| %-5.5s | %-5.5s | %5.5s | %s";

    private OutputHelper $outputHelper;

    public function __construct(OutputHelper $outputHelper)
    {
        $this->outputHelper = $outputHelper;
    }

    /**
     * @param ResponseElement[] $elements
     * @return void
     */
    public function makeOutput(array $elements): void
    {
        $this->outputHelper->emptyLine();
        $this->printTitle();


        foreach ($elements as $element) {
            $this->printRow([
                $element->getId(),
                $element->getScore(),
                $element->getPrice(),
                $element->getTitle(),
            ]);
        }
    }

    private function printTitle(): void
    {
        $this->printRow(['Id', 'Score', 'Price', 'Title']);
    }

    private function printRow(array $fields): void
    {
        $this->outputHelper->info(sprintf(self::MASK, ...$fields));
    }
}