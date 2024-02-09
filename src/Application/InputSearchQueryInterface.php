<?php

namespace Dimal\Hw11\Application;

interface InputSearchQueryInterface
{
    public function __invoke($params): SearchQueryDTO;
}