<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Infrastructure;

use Exception;
use Shabanov\Otusphp\Application\Dto\CreateHandlerRequest;
use Shabanov\Otusphp\Application\Dto\DataHandlerRequest;
use Shabanov\Otusphp\Application\Services\CreateHandler;
use Shabanov\Otusphp\Application\Services\DataHandler;
use Shabanov\Otusphp\Infrastructure\Db\ConnectionInterface;

class App
{
    private CONST DB_CONNECT = 'Shabanov\Otusphp\Infrastructure\Db\EsConnection';
    private CONST DB_CREATE_REPOSITORY = 'Shabanov\Otusphp\Infrastructure\Repository\EsCreateRepository';
    private CONST DB_DATA_REPOSITORY = 'Shabanov\Otusphp\Infrastructure\Repository\EsDataRepository';
    private CONST ES_DB_NAME = 'otus-shop';
    private CONST REQUEST_HANDLER = 'Shabanov\Otusphp\Infrastructure\Request\CliHandler';
    private CONST RENDER_HANDLER = 'Shabanov\Otusphp\Infrastructure\Render\BooksRender';
    private ConnectionInterface $connection;

    public function __construct()
    {
        $this->connection = self::DB_CONNECT::getInstance();
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        /**
         * Создадим индекс
         */
        $createRepository = new (self::DB_CREATE_REPOSITORY)($this->connection, self::ES_DB_NAME);
        $create = new CreateHandler(
            new CreateHandlerRequest($createRepository)
        );
        $create();

        /**
         * Получим данные
         */
        $dataRepository = new (self::DB_DATA_REPOSITORY)($this->connection,
            (new (self::REQUEST_HANDLER)())->process(),
            self::ES_DB_NAME);
        $data = new DataHandler(
            new DataHandlerRequest($dataRepository)
        );
        $dataCollection = $data();

        /**
         * Отобразим данные
         */
        echo (new (self::RENDER_HANDLER)($dataCollection->bookCollection))->getTable();
    }
}
