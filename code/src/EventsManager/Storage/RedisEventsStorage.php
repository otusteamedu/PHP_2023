<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw12\EventsManager\Storage;

class RedisEventsStorage extends EventsStorage
{
    private $redisConnection;

    public function __construct($arConnectionSettings)
    {
        \Predis\Autoloader::register();
        $this->redisConnection = new \Predis\Client($arConnectionSettings);
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

    public function add(array $arEventProps): void
    {
        $arParams = [];
        foreach ($arEventProps["conditions"] as $sName => $sValue) {
            $this->redisConnection->zAdd($sName . ":" . $sValue, $arEventProps["priority"], $arEventProps["event"]);

            $arParams[$sName] = $sValue;
        }

        $this->redisConnection->hmSet($arEventProps["event"], $arParams);
    }

    public function deleteAll(): void
    {
        $this->redisConnection->flushDb();
    }
}
