<?php

namespace App\Application\adapter;

interface AdapterInterface
{
    public function convert(array $result): array;
}
