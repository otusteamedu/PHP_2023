<?php

namespace Gkarman\Otuselastic\Commands\Classes;

class CreateDbCommand extends AbstractCommand
{
    public function run(): string
    {
         return $this->repository->createDB();
    }
}
