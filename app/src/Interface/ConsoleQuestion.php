<?php

declare(strict_types=1);

namespace YuzyukRoman\Hw11\Interface;

use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class ConsoleQuestion
{
    private InputInterface $input;
    private OutputInterface $output;
    private HelperSet $helper;

    public function __construct(InputInterface $input, OutputInterface $output, HelperSet $helper)
    {
        $this->input = $input;
        $this->output = $output;
        $this->helper = $helper;
    }

    public function askQuestion(string $questionText): string | null
    {
        $question = new Question($questionText);
        $helper = $this->helper->get('question');
        return $helper->ask($this->input, $this->output, $question);
    }
}
