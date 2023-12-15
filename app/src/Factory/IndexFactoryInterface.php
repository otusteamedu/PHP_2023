<?php

namespace App\Factory;

use Ehann\RediSearch\AbstractIndex;

interface IndexFactoryInterface
{
    public function create(): AbstractIndex;
}
