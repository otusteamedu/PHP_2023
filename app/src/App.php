<?php

namespace App;

class App
{
    private array $events;

    public function __construct()
    {
        $this->events = json_decode(file_get_contents(__DIR__ . '/events.json'), true);
    }

    public function run(): void
    {

    }
}