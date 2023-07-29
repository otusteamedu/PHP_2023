<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Infrastructure;

use VKorabelnikov\Hw15\EventsManager\Application\Storage\EventsStorageInterface;
use VKorabelnikov\Hw15\EventsManager\Application\Config\EventsConfigInterface;
use VKorabelnikov\Hw15\EventsManager\Domain\Model\Event;

class RedisEventsStorage implements EventsStorageInterface
{
    private $redisConnection;

    public function __construct(EventsConfigInterface $config)
    {
        \Predis\Autoloader::register();
        $this->redisConnection = new \Predis\Client(
            $this->getConnectionSettings($config)
        );
    }

    public function getConnectionSettings(EventsConfigInterface $config): array
    {
        $settings = $config->getAllSettings();

        if (!empty($settings["redis_connection_scheme"])) {
            $arRedisSettings["scheme"] = $settings["redis_connection_scheme"];
        } else {
            throw new \Exception("Не задан параметр redis_connection_scheme в config.ini");
        }

        if (!empty($settings["redis_connection_host"])) {
            $arRedisSettings["host"] = $settings["redis_connection_host"];
        } else {
            throw new \Exception("Не задан параметр redis_connection_host в config.ini");
        }

        if (!empty($settings["redis_connection_port"])) {
            $arRedisSettings["port"] = $settings["redis_connection_port"];
        } else {
            throw new \Exception("Не задан параметр redis_connection_port в config.ini");
        }

        return $arRedisSettings;
    }

    public function getByCondition(array $arConditions): string
    {
        $arIntersectConditions = [];
        foreach ($arConditions as $sConditionName => $sConditionValue) {
            $arIntersectConditions[] = $sConditionName . ":" . $sConditionValue;
        }

        // Получаем массив событий, подходящих под условия поиска.
        $arValue = $this->redisConnection->zInter($arIntersectConditions);

        if (empty($arValue) || !is_array($arValue)) {
            throw new \Exception("No events found");
        }

        // Проверяем, есть ли среди найденных событий событие, для которого выполнены все условия.
        // Массив событий отсортирован по позрастанию приоритета. Поэтому пробегаем массив начиная с конца.
        for ($i = (count($arValue) - 1); $i >= 0; $i--) {
            $arEventParams = $this->redisConnection->hGetAll($arValue[$i]);
            $bAllParamsMatch = true;
            foreach ($arEventParams as $paramName => $paramValue) {
                if (
                    !isset($arConditions[$paramName])
                    || $paramValue != $arConditions[$paramName]
                ) {
                    $bAllParamsMatch = false;
                }
            }

            if ($bAllParamsMatch) {
                return $arValue[$i];
            }
        }

        throw new \Exception("No events found");
    }

    public function add(Event $event): void
    {
        $arParams = [];

        $eventConditions = $event->getConditions();
        foreach ($eventConditions as $sName => $sValue) {
            $this->redisConnection->zAdd($sName . ":" . $sValue, $event->getPriority(), $event->getEvent());

            $arParams[$sName] = $sValue;
        }

        $this->redisConnection->hmSet($event->getEvent(), $arParams);
    }

    public function deleteAll(): void
    {
        $this->redisConnection->flushDb();
    }
}
