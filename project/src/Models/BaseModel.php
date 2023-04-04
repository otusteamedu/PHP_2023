<?php

declare(strict_types=1);

namespace Vp\App\Models;

use Exception;
use PDO;
use Vp\App\Exceptions\AddEntityFailed;
use Vp\App\Exceptions\FindEntityFailed;
use Vp\App\Exceptions\RelationException;
use Vp\App\Message;
use Vp\App\Services\DataBase;
use Vp\App\Storage\Relation;
use WS\Utils\Collections\Collection;
use WS\Utils\Collections\CollectionFactory;

abstract class BaseModel
{
    protected string $primaryKey = 'id';
    protected array $attributes = [];
    protected array $relations = [];

    public function __set(string $key, $value)
    {
        $this->setAttribute($key, $value);
    }

    private function setAttribute(string $key, $value): static
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * @throws RelationException
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * @throws RelationException
     */
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

    /**
     * @throws RelationException
     */
    public function getRelationValue($key)
    {
        if (array_key_exists($key, $this->relations)) {
            return $this->relations[$key];
        }

        return $this->getRelationFromMethod($key);
    }

    /**
     * @throws RelationException
     */
    protected function getRelationFromMethod($method)
    {
        $relation = $this->$method();

        if (!$relation instanceof Relation) {
            throw new RelationException('must return a relationship instance');
        }

        $this->setRelation($method, $relation->getCollection());
        return $this->relations[$method];
    }

    private function setRelation($relation, $value): static
    {
        $this->relations[$relation] = $value;
        return $this;
    }

    protected function getRelation(string $related): Relation
    {
        $instance = $this->newRelatedInstance($related);
        $foreignKey = $this->getForeignKey();
        $relation = new Relation($instance, $foreignKey, $this->attributes['id']);
        return $relation;
    }

    protected function newRelatedInstance($class)
    {
        return new $class();
    }

    private function getForeignKey(): string
    {
        $baseName = basename(str_replace('\\', '/', get_class($this)));
        return lcfirst($baseName . '_' . $this->getKeyName());
    }

    private function getKeyName(): string
    {
        return $this->primaryKey;
    }

    /**
     * @throws FindEntityFailed
     */
    public static function all(): Collection
    {
        $sql = "SELECT * FROM " . static::getTableName();
        return self::exec($sql);
    }

    /**
     * @throws FindEntityFailed
     */
    public static function find(string $id): Collection
    {
        $sql = 'SELECT * FROM ' . static::getTableName() . ' WHERE id=' . $id;
        return self::exec($sql);
    }

    /**
     * @throws FindEntityFailed
     */
    public static function where(string $attr, int $value): Collection
    {
        $sql = 'SELECT * FROM ' . static::getTableName() . ' WHERE ' . $attr . '=' . $value;
        return self::exec($sql);
    }

    /**
     * @throws FindEntityFailed
     */
    protected static function exec(string $sql): Collection
    {
        $db = DataBase::getInstance()->getConnection();
        $rows = [];

        try {
            foreach ($db->query($sql, PDO::FETCH_ASSOC) as $row) {
                $rows[] = $row;
            }

            return CollectionFactory::from($rows)->stream()->map(
                function ($fields) {
                    $model = new static();
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
        if (isset($this->id)) {
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
        $db = DataBase::getInstance()->getConnection();
        $updatedData = $this->prepareUpdatedData($this->attributes);
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $updatedData) . ' WHERE id = ' . $this->attributes[$this->primaryKey];
        return $db->query($sql);
    }

    private function insert(): \PDOStatement|bool
    {
        $db = DataBase::getInstance()->getConnection();
        [$columns, $values] = $this->prepareInsertData($this->attributes);
        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $values) . ')';
        return $db->query($sql);
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
