<?php

namespace Gkarman\Otuselastic\Commands\Classes;

class DeleteDbCommand extends AbstractCommand
{
    public function run(): string
    {
       return $this->repository->deleteDB();
    }
}
