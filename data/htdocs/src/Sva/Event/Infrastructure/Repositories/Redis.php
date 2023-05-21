<?php

namespace Sva\Event\Infrastructure\Repositories;

use RedisException;
use Sva\Common\Infrastructure\RedisConnection;
use Sva\Event\Domain\Event;

class Redis implements \Sva\Event\Domain\EventRepositoryInterface
{
    const DATA_KEY = 'event:data';
    const PRIORITY_KEY = 'event:priority';
    const CONDITION_KEY = 'event:conditions';

    /**
     * @var RedisConnection
     */
    private RedisConnection $connection;

    /**
     * Redis constructor.
     */
    public function __construct()
    {
        $this->connection = RedisConnection::getInstance();
    }

    /**
     * @param array $arParams
     * @return array
     * @throws RedisException
     */
    public function getList(array $arParams = []): array
    {
        $arKeys = [];
        $arResult = [];

        if (!empty($arParams)) {
            $hKeys = array_keys($arParams);
            $r = $this->connection->getConnection()->keys(self::CONDITION_KEY . ':*');

            foreach ($r as $key) {
                $b = [];
                $rConditions = $this->connection->getConnection()->hMGet($key, $hKeys);

                foreach ($arParams as $paramKey => $paramValue) {
                    $b[$paramKey] = $rConditions[$paramKey] == $paramValue;
                }

                $b = array_values(array_unique($b));
                if (count($b) == 1 && $b[0] == true) {
                    $key = intval(substr($key, strlen(self::CONDITION_KEY . ':')));
                    $arKeys[] = $key;
                }
            }
        } else {
            $r = $this->connection->getConnection()->keys(self::DATA_KEY . ':*');
            foreach ($r as $key) {
                $key = intval(substr($key, strlen(self::DATA_KEY . ':')));
                $arKeys[] = $key;
            }
        }

        /**/
        foreach ($arKeys as $key) {
            $priority = $this->getPriority($key);
            $data = $this->getData($key);
            $conditions = $this->getConditions($key);

            $arResult[] = new Event($priority, $conditions, $data);
        }

        return $arResult;
    }

    /**
     * @param Event $event
     * @return bool
     * @throws RedisException
     */
    public function add(Event $event): bool
    {
        $key = $this->getNextEventKey();

        $trns = $this->connection->getConnection()->multi();

        // Сохраняем событие
        $trns->set(self::DATA_KEY . ':' . $key, json_encode($event->getEvent()));

        // Сохраняем условия
        foreach ($event->getConditions() as $conditionKey => $condition) {
            $trns->hSet(self::CONDITION_KEY . ':' . $key, $conditionKey, json_encode($condition));
        }

        // Сохраняем приоритет
        $trns->zAdd(self::PRIORITY_KEY, json_encode($event->getPriority()), $key);

        // выполняем
        $trns->exec();

        return true;
    }

    /**
     * @return int
     * @throws RedisException
     */
    private function getNextEventKey(): int
    {
        $cnt = count($this->connection->getConnection()->keys(self::DATA_KEY . '*'));
        return $cnt + 1;
    }

    /**
     * @param string $key
     * @return int
     * @throws RedisException
     */
    private function getPriority(string $key): int
    {
        $r = $this->connection->getConnection()->zScore(self::PRIORITY_KEY, $key);

        return $r;
    }

    /**
     * @param string $key
     * @return array
     * @throws RedisException
     */
    private function getData(string $key): array
    {
        $r = $this->connection->getConnection()->get(self::DATA_KEY . ':' . $key);

        return json_decode($r, true) ?? [];
    }

    /**
     * @param string $key
     * @return array
     * @throws RedisException
     */
    private function getConditions(string $key): array
    {
        $r = $this->connection->getConnection()->hGetAll(self::CONDITION_KEY . ':' . $key);

        return $r;
    }

    public function search(array $params): array
    {
        $result = [];
        $hKeys = array_keys($params);
        $r = $this->connection->getConnection()->keys(self::CONDITION_KEY . ':*');

        foreach ($r as $key) {
            $rConditions = $this->connection->getConnection()->hMGet($key, $hKeys);

            foreach ($rConditions as $conditionKey => $conditionValue) {
                if ($conditionValue == $params[$conditionKey]) {
                    $result[] = $key;
                }
            }
        }

        return $result;
    }

    public function clear(): bool
    {
        try {
            $keys = $this->connection->getConnection()->keys('event:*');
            foreach ($keys as $key) {
                $this->connection->getConnection()->del($key);
            }
            return true;
        } catch (RedisException $e) {
            return false;
        }
    }
}
