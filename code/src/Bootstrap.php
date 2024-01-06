<?php

namespace Radovinetch\Hw11;

use Dotenv\Dotenv;
use Radovinetch\Hw11\commands\Command;
use Radovinetch\Hw11\commands\CreateCommand;
use Radovinetch\Hw11\commands\DeleteCommand;
use Radovinetch\Hw11\commands\SearchController;
use RuntimeException;
use Throwable;

class Bootstrap
{
    /**
     * @var Command[]
     */
    protected array $commands = [];
    public function init(array $options): void
    {
        try {
            $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
            $dotenv->load();

            $storage = new Storage();

            $this->commands['create'] = new CreateCommand($storage);
            $this->commands['delete'] = new DeleteCommand($storage);
            $this->commands['search'] = new SearchController($storage);

            if (!isset($this->commands[$options['c']])) {
                throw new RuntimeException('Не найдена команда ' . $options['c']);
            }

            $this->commands[$options['c']]->run($options);
        } catch (Throwable $throwable) {
            echo 'Произошла ошибка при выполнении программы!' . PHP_EOL .
                'Текст ошибки: ' . $throwable->getMessage() . PHP_EOL .
                $throwable->getTraceAsString();
        }
    }
}