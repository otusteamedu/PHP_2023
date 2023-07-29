<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Infrastructure;

use VKorabelnikov\Hw15\EventsManager\Application\Storage\EventsStorageInterface;
use VKorabelnikov\Hw15\EventsManager\Application\Config\EventsConfigInterface;
use VKorabelnikov\Hw15\EventsManager\Domain\Model\Event;

use VKorabelnikov\Hw15\EventsManager\Domain\ValueObject\Priority;
use VKorabelnikov\Hw15\EventsManager\Domain\ValueObject\ConditionList;
use VKorabelnikov\Hw15\EventsManager\Domain\ValueObject\EventTitle;

class RedisEventsStorage implements EventsStorageInterface
{
    const PREDIS_CONNECTION_SETTINGS_MAP = [
        "scheme" => "redis_connection_scheme",
        "host" => "redis_connection_host",
        "port" => "redis_connection_port"
    ];

    private $redisConnection;

    public function __construct(EventsConfigInterface $config)
    {
        $settings = $config->getAllSettings();
        $this->assertValidSettings($settings);

        \Predis\Autoloader::register();
        $this->redisConnection = new \Predis\Client(
            $this->getConnectionSettings($settings)
        );
    }

    private function getConnectionSettings(array $settings): array
    {
        $predisSettings = [];

        foreach (self::PREDIS_CONNECTION_SETTINGS_MAP as $predisSettingName => $appSettingName) {
            $predisSettings[$predisSettingName] = $settings[$appSettingName];
        }

        return $predisSettings;
    }

    private function assertValidSettings(array $settings): void
    {
        foreach (self::PREDIS_CONNECTION_SETTINGS_MAP as $appSettingName) {
            if (empty($settings[$appSettingName])) {
                throw new \Exception("Не задан параметр " . $appSettingName . " в config.ini");
            }
        }
    }

    public function getByCondition(ConditionList $conditionsList): EventTitle
    {
        $arIntersectConditions = [];
        $arConditions = $conditionsList->getValue();
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
                return new EventTitle($arValue[$i]);
            }
        }

        throw new \Exception("No events found");
    }

    public function add(Event $event): void
    {
        $arParams = [];

        $eventConditions = $event->getConditions()->getValue();
        foreach ($eventConditions as $sName => $sValue) {
            $this->redisConnection->zAdd($sName . ":" . $sValue, $event->getPriority()->getValue(), $event->getEventTitle()->getValue());

            $arParams[$sName] = $sValue;
        }

        $this->redisConnection->hmSet($event->getEventTitle()->getValue(), $arParams);
    }

    public function deleteAll(): void
    {
        $this->redisConnection->flushDb();
    }
}
