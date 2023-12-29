<?php

namespace App\Application\Log;

class Log
{
    public function useRespond(mixed $respond): void
    {
        if ($onceResponse = print_r($respond, true)) {
            $lines = [
                PHP_EOL,
                'Ответ для пользователя: ',
                $onceResponse,
                PHP_EOL
            ];
            foreach ($lines as $line) {
                $this->print($line);
            }
        }
    }

    private function print(string $line): void
    {
        echo $line;
    }
}
