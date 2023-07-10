<?php

declare(strict_types=1);

namespace Otus\App\Youtube\Command;

use Otus\App\Elastic\Client;
use Otus\App\Youtube\Statistic;

final readonly class StatisticCommand implements CommandInterface
{
    public function __construct(
        private Statistic $statistic,
    ) {
    }

    public function execute(): int
    {
        $topChannels = $this->statistic->topChannels(10);
        fwrite(STDOUT, print_r($topChannels, true));

        $sumOfLikesAndDislikes = $this->statistic->sumOfLikesAndDislikes('channel_5');
        fwrite(STDOUT, print_r($sumOfLikesAndDislikes, true));

        return 0;
    }


}
