<?php

declare(strict_types=1);

namespace Root\App;

use RedisException;

class App
{
    const COMMAND_BULK = 'bulk';
    const COMMAND_ADD = 'add';
    const COMMAND_GET = 'get';
    const COMMAND_CLEAR = 'clear';

    private ?string $cmd = null;
    private ?string $cmdParam = null;

    private ?StorageInterface $storage;

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
        switch ($this->cmd) {
            case self::COMMAND_ADD:
                $this->commandAdd();
                break;
            case self::COMMAND_BULK:
                $this->commandBulk();
                break;
            case self::COMMAND_GET:
                $result = $this->commandGet();
                $this->print($result);
                break;
            case self::COMMAND_CLEAR:
                $this->storage->clear();
                break;
            default:
                $this->showHelp();
        }
    }

    private function parseArg(): void
    {
        $opt = getopt('b:a:g:c');

        if (isset($opt['b'])) {
            $this->cmd = self::COMMAND_BULK;
            $this->cmdParam = $opt['b'];
        }
        if (isset($opt['a'])) {
            $this->cmd = self::COMMAND_ADD;
            $this->cmdParam = $opt['a'];
        }
        if (isset($opt['g'])) {
            $this->cmd = self::COMMAND_GET;
            $this->cmdParam = $opt['g'];
        }
        if (isset($opt['c'])) {
            $this->cmd = self::COMMAND_CLEAR;
        }
    }

    private function showHelp(): void
    {
        echo "Usage: index.php COMMAND [PARAMS]\n\n"
            . "COMMAND:\n"
            . "\t-b filename\t load data from json file\n"
            . "\t-a value\t add event (json string)\n"
            . "\t-g value\t get event (json string)\n"
            . "\t-c\t\t clear data\n";
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
        if (!is_array($json)) {
            throw new AppException('Error parse json string');
        }
        $this->storage->add($json);
    }

    /**
     * @throws AppException
     * @throws RedisException
     */
    private function commandBulk(): void
    {
        if (empty($this->cmdParam)) {
            throw new AppException('Bulk expect json file');
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
