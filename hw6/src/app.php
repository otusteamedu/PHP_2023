<?php
declare(strict_types=1);

namespace Elena\Hw6;

use Exception;

class App
{
    public function run($argv){

        try {
            if (!isset($argv[1])) {
                throw new \InvalidArgumentException('Нет данных о процессе ');
            }

            switch ($argv[1]) {
                case 'client':
                    $proc = new Client();
                    $proc->action(new Socket());
                    break;
                case 'server':
                    $proc = new Server();
                    $proc->action(new Socket());
                    break;
            }
        } catch (\Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }


    }
}





