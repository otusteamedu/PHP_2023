<?php

namespace Dimal\Hw11\Application;

interface TableViewInterface
{
    public function showTable(array $cols, array $rows): void;
}