<?php
declare(strict_types=1);

namespace Shabanov\Otusphp;

use Exception;
use Shabanov\Otusphp\Application\Dto\DataHandlerRequest;
use Shabanov\Otusphp\Application\Services\CreateHandler;
use Shabanov\Otusphp\Application\Services\DataHandler;
use Shabanov\Otusphp\Infrastructure\Db\ConnectionInterface;

class App
{
    private CONST DB_CONNECT = 'Shabanov\Otusphp\Infrastructure\Db\EsConnection';
    private CONST DB_CREATE_REPOSITORY = 'Shabanov\Otusphp\Infrastructure\Repository\Query\EsQueryHandler';
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
        $queryHandler = new (self::DB_CREATE_REPOSITORY)($this->connection, self::ES_DB_NAME);
        $create = new CreateHandler();
        $create($queryHandler);

        /**
         * Получим данные
         */
        $request = (new (self::REQUEST_HANDLER)());
        $dataRepository = new (self::DB_DATA_REPOSITORY)(
            $this->connection,
            self::ES_DB_NAME
        );
        $data = new DataHandler(
            new DataHandlerRequest($request->process())
        );

        $dataCollection = $data($dataRepository);

        /**
         * Отобразим данные
         */
        echo (new (self::RENDER_HANDLER)($dataCollection))->getTable();
    }
}
