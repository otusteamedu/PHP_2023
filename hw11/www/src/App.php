<?php
declare(strict_types=1);
namespace Shabanov\Otusphp;

use Exception;
use Shabanov\Otusphp\Es\EsConnection;
use Shabanov\Otusphp\Es\EsCreateIndex;
use Shabanov\Otusphp\Es\EsDataHandler;
use Shabanov\Otusphp\Cli\CliHandler;

class App
{
    private CONST ES_INDEX_NAME = 'otus-shop';
    private EsConnection $esConnection;

    public function __construct()
    {
        $this->esConnection = EsConnection::getInstance();
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        (new EsCreateIndex($this->esConnection, self::ES_INDEX_NAME))
            ->run();
        echo (new EsDataHandler(
            $this->esConnection,
            (new CliHandler())->run(),
            self::ES_INDEX_NAME
        ))->getTable();
    }
}
