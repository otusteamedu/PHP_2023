<?php

declare(strict_types=1);

namespace src\view;

class ConsoleClient
{
    private array $data;
    private int $countOfCollection;

    public function render(array $allData): void
    {
        $this->countOfCollection = $allData['count'] ?? 0;
        $this->data = $allData['data'] ?? [];
    }

    public function view(): void
    {
        $this->info('Loaded: `' . $this->countOfCollection . '` rows.');
        $this->info("+--+----\t\t+-----\t\t+------\t\t+------\t\t+");
        $this->info("|###|user\t\t|event\t\t|notify\t\t|detail\t\t|");
        $this->info("+--+----\t\t+-----\t\t+------\t\t+------\t\t+");

        /** @var UserViewDTO $item */
        foreach ($this->data as $n => $item) {
            $numb   = sprintf("%3d", $n + 1);
            $user   = sprintf("%-12s", $item->getUser());
            $event  = sprintf("%-12s", $item->getEvent());
            $notify = sprintf("%-12s", $item->getNotify());
            $detail = sprintf("%-15s", $item->getDetail());
            $this->info("|{$numb}|{$user}\t|{$event}\t|{$notify}\t|{$detail}|");
        }

        $this->info("+---+----\t\t+-----\t\t+------\t\t+------\t\t+");
    }

    private function info(string $message): void
    {
        echo $message;
        echo PHP_EOL;
    }
}
