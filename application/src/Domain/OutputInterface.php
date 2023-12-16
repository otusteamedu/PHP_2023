<?php

namespace Gesparo\Homework\Domain;

interface OutputInterface
{
    public function send(string $message);
}