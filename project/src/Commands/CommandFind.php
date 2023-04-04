<?php

declare(strict_types=1);

namespace Vp\App\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use LucidFrame\Console\ConsoleTable;
use Vp\App\Services\Container;
use Vp\App\Storage\Find;
use WS\Utils\Collections\Collection;

class CommandFind implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(array $argv): void
    {
        if (isset($argv[2])) {
            $id = $argv[2];
        }

        $find = Container::getInstance()->get(Find::class);
        $result = $find->work($id ?? null);
        $table = $this->createConsoleTable($result->getResult());
        fwrite(STDOUT, $result . PHP_EOL);
        $table->display();
    }

    private function createConsoleTable(Collection $collection): ConsoleTable
    {
        $table = new ConsoleTable();
        $table
            ->addHeader('id')
            ->addHeader('login')
            ->addHeader('email')
            ->addHeader('first_name')
            ->addHeader('last_name');

        foreach ($collection as $model) {
            $table->addRow();
            $table->addColumn($model->id);
            $table->addColumn($model->login);
            $table->addColumn($model->email);

            $profileCollection = $model->profile;
            $profile = $profileCollection->stream()->findFirst();

            $table->addColumn($profile->first_name);
            $table->addColumn($profile->last_name);
        }
        return $table;
    }
}
