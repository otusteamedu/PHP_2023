<?php

declare(strict_types=1);

namespace Vp\App\Domain\Model;

use Exception;
use PDO;
use Vp\App\Application\Exception\AddEntityFailed;
use Vp\App\Application\Exception\FindEntityFailed;
use Vp\App\Application\Message;
use Vp\App\Domain\Contract\DatabaseInterface;
use WS\Utils\Collections\Collection;
use WS\Utils\Collections\CollectionFactory;

abstract class BaseModel
{
    protected string $primaryKey = 'id';
    protected array $attributes = [];
    protected array $relations = [];
    protected DatabaseInterface $db;

    public function __construct(DatabaseInterface $database)
    {
        $this->db = $database;
    }

    public function __set(string $key, $value)
    {
        $this->setAttribute($key, $value);
    }

    private function setAttribute(string $key, $value): static
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function getAttribute($key)
    {
        if (!$key) {
            return;
        }

        if (array_key_exists($key, $this->attributes)) {
            return $this->getAttributeValue($key);
        }

        if (method_exists(self::class, $key)) {
            return;
        }

        return $this->getRelationValue($key);
    }

    private function getAttributeValue($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function getRelationValue($key)
    {
        if (array_key_exists($key, $this->relations)) {
            return $this->relations[$key];
        }

        return $this->getRelationFromMethod($key);
    }

    protected function getRelationFromMethod($method)
    {
        $relation = $this->$method();
        $this->setRelation($method, $relation);
        return $this->relations[$method];
    }

    private function setRelation($relation, $value): static
    {
        $this->relations[$relation] = $value;
        return $this;
    }

    /**
     * @throws FindEntityFailed
     */
    public function all(): Collection
    {
        $sql = "SELECT * FROM " . static::getTableName();
        return self::exec($sql);
    }

    /**
     * @throws FindEntityFailed
     */
    public function findOne(int $id): BaseModel
    {
        $collection = $this->find($id);

        if ($collection->size() < 1) {
            throw new FindEntityFailed('Model not found for given ID');
        }

        return $collection->stream()->findFirst();
    }

    /**
     * @throws FindEntityFailed
     */
    public function find(int $id): Collection
    {
        $sql = 'SELECT * FROM ' . static::getTableName() . ' WHERE id=' . $id;
        return $this->exec($sql);
    }

    /**
     * @throws FindEntityFailed
     */
    public function where(string $attr, string $value): Collection
    {
        $sql = "SELECT * FROM " . static::getTableName() . " WHERE " . $attr . "='" . $value . "'";
        return self::exec($sql);
    }

    /**
     * @throws FindEntityFailed
     */
    protected function exec(string $sql): Collection
    {
        $db = $this->db->getConnection();
        $rows = [];

        try {
            foreach ($db->query($sql, PDO::FETCH_ASSOC) as $row) {
                $rows[] = $row;
            }

            return CollectionFactory::from($rows)->stream()->map(
                function ($fields) {
                    $model = new static($this->db);
                    foreach ($fields as $field => $value) {
                        $model->{$field} = $value;
                    }
                    return $model;
                }
            )->getCollection();
        } catch (Exception $e) {
            throw new FindEntityFailed(Message::FAILED_READ_ENTITY . ': ' . $e->getMessage());
        }
    }

    /**
     * @throws AddEntityFailed
     */
    public function save(): void
    {
        if ($this->getAttributeValue('id') !== null) {
            $result = $this->update();
        } else {
            $result = $this->insert();
        }

        if ($result === false) {
            throw new AddEntityFailed('Error. Failed to complete the request.');
        }
    }

    private function update(): \PDOStatement|bool
    {
        $dbConn = $this->db->getConnection();
        $updatedData = $this->prepareUpdatedData($this->attributes);
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $updatedData) . ' WHERE id = ' . $this->attributes[$this->primaryKey];
        return $dbConn->query($sql);
    }

    private function insert(): \PDOStatement|bool
    {
        $dbConn = $this->db->getConnection();
        [$columns, $values] = $this->prepareInsertData($this->attributes);
        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $values) . ')';
        $res = $dbConn->query($sql);
        if ($res !== false) {
            $id = $dbConn->lastInsertId();
            $this->setAttribute('id', is_numeric($id) ? (int) $id : $id);
        }
        return $res;
    }

    private function prepareUpdatedData(array $attributes): array
    {
        $attributeValues = [];
        unset($attributes[$this->primaryKey]);
        foreach ($attributes as $key => $value) {
            $attributeValues[] = $key . '=\'' . $value . '\'';
        }
        return $attributeValues;
    }

    private function prepareInsertData(array $attributes): array
    {
        $values = [];
        $columns = array_keys($attributes);
        $attributeValues = array_values($attributes);

        foreach ($attributeValues as $value) {
            $values[] = '\'' . $value . '\'';
        }

        return [$columns, $values];
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    abstract protected static function getTableName(): string;
}
