<?php

namespace Shabanov\Otusphp;

use Shabanov\Otusphp\Db\Postgres;

class App
{
    private Postgres $dbPg;
    public function __construct()
    {
        $this->dbPg = new Postgres();
    }

    public function run(): void
    {
        echo $this->dbPg
            ->createTables()
            //->createData()
            ->getProfitFilm();
    }
}
