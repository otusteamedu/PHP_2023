<?php

namespace Yakovgulyuta\Hw13\Core\Database\ActiveRecord;

use Yakovgulyuta\Hw13\Entity\Cinema;

abstract class Model
{
    public const TABLE_NAME = '';
    public int $id;

    public function insert(): int
    {
        $fields = get_object_vars($this);
        $cols = [];
        $data = [];
        foreach ($fields as $name => $value) {
            if ($name === 'id') {
                continue;
            }
            $cols[] = $name;
            $data[':' . $name] = $value;
        }

        $sql =
            "INSERT INTO " . static::TABLE_NAME . " (" .
            implode(',', $cols) . ") VALUES (" .
            implode(',', array_keys($data)) . ")";


        $db = new Db();
        $db->execute($sql, $data);

        return $db->lastId();
    }

    public function update(int $id)
    {
        $this->id = $id;

        $fields = get_object_vars($this);

        $data = [];
        $string = '';
        foreach ($fields as $name => $value) {
            $data[':' . $name] = $value;

        }
        foreach (array_keys($data) as $val) {
            $string .= trim($val, ':') . ' = ' . $val . ', ';
        }

        $sql = "UPDATE " . static::TABLE_NAME . " SET " .
            rtrim($string, ' ,') . " WHERE id = :id";

        $db = new Db();

        return $db->query($sql, $data, static::class)[0];
    }

    public static function delete(int $id): bool
    {
        $db = new Db();
        $sql = "DELETE FROM " . static::TABLE_NAME . " WHERE id = :id";

        $db->execute($sql, ['id' => $id]);
        return true;
    }

    public static function read(int $id): Cinema|null
    {

        $db = new Db();

        $sql = "SELECT * FROM " . static::TABLE_NAME . " WHERE id = :id";
        $stmt = $db->query($sql, ['id' => $id], static::class);
        if (count($stmt)) {
            return $stmt[0];
        }
        return null;
    }

    public static function findByField(string $field, int $id): array|null
    {

        $db = new Db();

        $sql = "SELECT * FROM " . static::TABLE_NAME . " WHERE $field = :$field";

        $stmt = $db->queryLazy($sql, [$field => $id], static::class);
        if (count($stmt)) {
            return $stmt;
        }
        return null;
    }

    public static function findAll(): false|array
    {
        $db = new Db();
        return $db->query("SELECT * FROM " . static::TABLE_NAME, [], static::class);
    }

    public function getId(): int
    {
        return $this->id;
    }

}
