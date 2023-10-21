<?php

declare(strict_types=1);


namespace Root\App;

use RedisException;
use Root\App\Command;

class App
{


    private ?string $cmd = null;
    private ?string $cmdParam = null;

    private ?IStorage $storage;

    public function __construct()
    {
        set_time_limit(0);
        mb_internal_encoding('UTF-8');

        $this->parseArg();

        $this->storage = new RedisStorage();
    }

    /**
     * @throws AppException
     * @throws RedisException
     */
    public function run(): void
    {
 
        var_dump($_SERVER);
        exit;
         if (empty($this->cmd)) throw new AppException('Empty argument'); 
         match (strtoupper($this->cmd)) {
            Command::ADD => $this->commandAdd(),
            Command::LOAD => $this->commandLoadFile(),
            Command::GET => $this->print($this->commandGet() ),
            Command::CLEAR => $this->storage->clear(),
            default => $this->showHelp()
        };
       
    }

    private function parseArg(): void
    {
        $opt = getopt('l:a:g:c:h');

        if (isset($opt['l'])) {
            $this->cmd = Command::LOAD;
            $this->cmdParam = $opt['l'];
        }
        if (isset($opt['a'])) {
            $this->cmd = Command::ADD;
            $this->cmdParam = $opt['a'];
        }
        if (isset($opt['g'])) {
            $this->cmd = Command::GET;
            $this->cmdParam = $opt['g'];
        }
        if (isset($opt['c'])) {
            $this->cmd = Command::CLEAR;
        }
        if (isset($opt['h'])) {
            $this->cmd = Command::HELP;
        }
    }

    private function showHelp(): void
    {
        echo "Usage: index.php COMMAND [PARAMS]\n\n"
            . "COMMAND:\n"
            . "\t-load filename\t load data from json file\n"
            . "\t-add value\t add event (json string)\n"
            . "\t-get value\t get event (json string)\n"
            . "\t-clear\t\t clear data\n";
    }

    /**
     * @throws AppException
     * @throws RedisException
     */
    private function commandAdd(): void
    {
        if (empty($this->cmdParam)) {
            throw new AppException('Add expect json string');
        }
        
        $json = json_decode($this->cmdParam, true);
        
        if ( json_last_error() === JSON_ERROR_SYNTAX) throw new AppException('Error parse json string');

        $this->storage->add($json);
    }

    /**
     * @throws AppException
     * @throws RedisException
     */
    private function commandLoadFile(): void
    {
        if (empty($this->cmdParam)) {
            throw new AppException('Failed to load json file');
        }
        if (!is_readable($this->cmdParam)) {
            throw new AppException('Error reading json file');
        }
        $content = file_get_contents($this->cmdParam);
        if (empty($content)) {
            throw new AppException('Empty file');
        }
        $json = json_decode($content, true);
        if (!is_array($json)) {
            throw new AppException('Error parse file content');
        }
        foreach ($json as $value) {
            $this->storage->add($value);
        }
    }

    /**
     * @throws AppException
     * @throws RedisException
     */
    private function commandGet(): ?array
    {
        if (empty($this->cmdParam)) {
            throw new AppException('Get expect json string');
        }
        $json = json_decode($this->cmdParam, true);
        if (!is_array($json)) {
            throw new AppException('Error parse json string');
        }
        return $this->storage->get($json);
    }

    private function print(?array $event): void
    {
        echo 'Event: ' . json_encode($event, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    }
}
