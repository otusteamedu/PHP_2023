<?php

declare(strict_types=1);

namespace Otus\App;

use Otus\App\Elastic\Client;
use Otus\App\Youtube\Command\CommandInterface;
use Otus\App\Youtube\Command\CreateIndexCommand;
use Otus\App\Youtube\Command\PopulateCommand;
use Otus\App\Youtube\Normalizer\ChannelNormalizer;
use Otus\App\Youtube\Normalizer\VideoNormalizer;
use Otus\App\Youtube\Command\StatisticCommand;
use Otus\App\Youtube\Statistic;

final class App
{
    public function run(): void
    {
        $command = $this->resolveCommand();

        $command->execute();
    }

    private function resolveCommand(): CommandInterface
    {
        $commandName = $_SERVER['argv'][1] ?? null;

        return match ($commandName) {
            'create-index' => (new CreateIndexCommand(new Client())),
            'populate' => (new PopulateCommand(new Client(), new ChannelNormalizer(), new VideoNormalizer())),
            'stat' => (new StatisticCommand(new Statistic(new Client()))),
            default => throw new \InvalidArgumentException("Command $commandName not found"),
        };
    }
}
