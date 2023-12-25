<?php

namespace App\Infrastructure\Repository;

use App\Application\ReadDataHelper;
use App\Domain\Entity\Book;
use ClickHouseDB\Client;


class ClickHouseRepository implements RepositoryInterface
{
    public Client $client;
    private int $size;

    private const SELECT_FIELDS = ['sku', 'title', 'category', 'price', 'stock_json as stock'];
    private const SELECT_TABLE = 'qa_book';

    public function __construct(
        string $host,
        string $user,
        string $password,
        string $port,
        string $size,
        string $db,
    )
    {
        $this->client = new Client([
            'host' => $host,
            'port' => $port,
            'username' => $user,
            'password' => $password,
        ]);
        $this->client->database($db);
        $this->size = $size;
    }

    public function searchByTitle(string $title): array
    {
        $firstSubTitle = mb_substr($title, 0, 3);
        $limit = $this->getSize();
        $fields = implode(', ', $this::SELECT_FIELDS);
        $table = $this::SELECT_TABLE;
        $where = "title like '%{$firstSubTitle}%'";
        $query = "SELECT {$fields} FROM {$table} where {$where} limit {$limit}";

        return $this->searchByQuery($query);
    }

    public function searchByTitleCategoryPrice(
        string $title,
        string $category,
        string $price
    ): array
    {
        $firstSubTitle = mb_substr($title, 0, 3);
        $limit = $this->getSize();
        $fields = implode(', ', $this::SELECT_FIELDS);
        $table = $this::SELECT_TABLE;
        $where = "title like '%{$firstSubTitle}%' and category like '%{$category}%' and price {$price}";
        $query = "SELECT {$fields} FROM {$table} where {$where} limit {$limit}";
var_dump($query);
        return $this->searchByQuery($query);
    }

    private function searchByQuery($query): array
    {
        $result = $this->client->select($query);

        if (!$result->count()) {
            return [];
        }

        return $result->rows();
    }

    private function getSize(): int
    {
        return $this->size;
    }

    /**
     * @throws \Exception
     */
    public function isDataValid(): bool
    {
        $table = $this::SELECT_TABLE;
        $db = $this->client->settings()->getSetting('database');

        return !empty($this->client->isExists($db, $table));
    }

    public function init(): void
    {
        $table = $this::SELECT_TABLE;
        $this->createTable($table);
        $data = (new ReadDataHelper())->doing();
        $this->insertData($table, $data);
    }

    private function createTable(string $table): void
    {
        $queryCommand =
            'CREATE TABLE ' . $table .
            '(id UInt32, sku String, title String, category String, price UInt16, stock_json String)'.
            'ENGINE = MergeTree() ORDER BY (id);';

        $this->client->write($queryCommand);
    }

    private function insertData(string $table, array $rows): void
    {
        $this->client->insert($table, $rows);
    }

    public function clearData(): void
    {
        $table = $this::SELECT_TABLE;
        $queryCommand = "drop table  {$table}";
        $this->client->write($queryCommand);
    }
}
