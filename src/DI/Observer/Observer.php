<?php

namespace HW11\Elastic\DI\Observer;

interface Observer
{
    public function update(string $status): void;
}
