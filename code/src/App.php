<?php

namespace Otus\Homework3;

use Otus\Homework3\Service\BracketService;
use Vladimirsannikov\Bracketchecker\EmptyBracketSequenceException;

class App
{
    private BracketService $bracketService;

    public function __construct(BracketService $bracketService)
    {
        $this->bracketService = $bracketService;
    }

    public function run()
    {
        $s = '(())';
        try {
            $result = $this->bracketService->check($s);
            if ($result) {
                echo 'Правильная скобочная последовательность';
            } else {
                echo 'Неправильная скобочная последовательность';
            }
        } catch (EmptyBracketSequenceException $e) {
            echo $e->getMessage();
        }
    }
}
