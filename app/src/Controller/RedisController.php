<?php

declare(strict_types=1);

namespace DEsaulenko\Hw12\Controller;

use DEsaulenko\Hw12\Constants;

class RedisController extends AbstractController implements ControllerInterface
{
    public const ADD_DATA_VALIDATE_ERROR = 'Формат передаваемых данных не валидный';
    protected string $key;
    protected string $value;

    public function add(string $json): void
    {
        $data = json_decode($json, true);
        if (!$data) {
            throw new \Exception(self::ADD_DATA_VALIDATE_ERROR);
        }

        $values = $data;
        $values = json_encode($values);
        $key = Constants::CONDITION_KEY . Constants::KEY_SEPARATOR .
            implode(Constants::KEY_SEPARATOR, $data['conditions']);
        $this->storage->create($key, $values, (int)$data['priority']);
    }

    public function getEvent(string $json): string
    {
        $conditions = json_decode($json, true);
        if (
            !$conditions
            || !$conditions['params']
        ) {
            throw new \Exception(self::ADD_DATA_VALIDATE_ERROR);
        }

        $key = Constants::CONDITION_KEY;
        $result = [];
        foreach ($conditions['params'] as $condition) {
            $key .= Constants::KEY_SEPARATOR . $condition;
            $r = $this->get($key);
            foreach ($r as $k => $value) {
                $result[$k][] = $value;
            }
        }
        if (!$result) {
            return '';
        }

        krsort($result);
        return current(current($result));
    }

    public function get(string $key)
    {
        return $this->storage->read($key);
    }

    public function deleteAll(): void
    {
        $this->storage->deleteAll();
    }
}
