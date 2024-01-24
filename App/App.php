<?php

declare(strict_types=1);

namespace App;

use src\Infrastructure\DBGateway\Tickets;

class App
{
    public function run(array $argv)
    {
        $tickets = new Tickets(new \PDO( "pgsql:host=postgreSQL;dbname=postgres", "postgres", "postgres"));
        $ticket = $tickets->getById(4);
    }
}
