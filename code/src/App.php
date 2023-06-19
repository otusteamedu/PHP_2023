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

    public function run(string $brackets)
    {
        try {
            $result = $this->bracketService->check($brackets);
            return $result;
        } catch (EmptyBracketSequenceException $e) {
            echo $e->getMessage();
        }
        return false;
    }
}
