<?php

declare(strict_types=1);

namespace YuzyukRoman\Hw11;

use Error;
use Exception;
use Symfony\Component\Console\Application;
use YuzyukRoman\Hw11\Console\CreateIndex;
use YuzyukRoman\Hw11\Console\FillIndex;
use YuzyukRoman\Hw11\Console\SearchBook;

class App
{
    public function start(): void
    {
        try {
            $app = new Application();

            $app->add(new FillIndex());
            $app->add(new CreateIndex());
            $app->add(new SearchBook());

            $app->run();
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }
}
