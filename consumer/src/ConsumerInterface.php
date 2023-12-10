<?php

namespace App;

interface ConsumerInterface
{
    public function run(): void;
}