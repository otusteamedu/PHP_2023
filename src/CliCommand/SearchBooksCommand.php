<?php

declare(strict_types=1);

namespace App\CliCommand;

use App\Service\DocumentSearcher;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class SearchBooksCommand extends CommandTemplate
{
    protected function configure()
    {
        $this
            ->setName('search:books')
            ->setDescription('Search books')
            ->addArgument('title', InputArgument::REQUIRED)
            ->addArgument('category', InputArgument::REQUIRED)
            ->addArgument('price', InputArgument::REQUIRED);
    }

    public function run(InputInterface $input, OutputInterface $output): int
    {
        $questionHelper = $this->getHelper('question');

        $title = $questionHelper->ask($input, $output, new Question('<info>title: </info>'));
        $category = $questionHelper->ask($input, $output, new Question('<info>category: </info>'));
        $price = $questionHelper->ask($input, $output, new Question('<info>price<comment>(<=)</comment>: </info>'));


        if ($title !== null && $category !== null && $price !== null) {
            $response = (new DocumentSearcher())->execute(self::INDEX_NAME, $title, $category, intval($price));
        } else {
            $output->writeln("<comment>Did not fill in parameters: title, category, price</comment>");

            return self::SUCCESS_CODE;
        }

        $output->writeln(
            sprintf("<comment>Total docs: %d\n</comment>", $response['hits']['total']['value'])
            . sprintf("<comment>Max score : %.4f\n</comment>", $response['hits']['max_score'])
            . sprintf("<comment>Took      : %d ms\n</comment>", $response['took'])
            . print_r($response['hits']['hits'], true)
        );

        return self::SUCCESS_CODE;
    }
}

