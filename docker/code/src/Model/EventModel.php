<?php

namespace IilyukDmitryi\App\Model;

use IilyukDmitryi\App\Storage\Base\EventStorageInterface;
use IilyukDmitryi\App\Storage\StorageApp;
use IilyukDmitryi\App\Utils\Helper;
use InvalidArgumentException;

class EventModel
{
    private ?EventStorageInterface $storage;

    public function __construct()
    {
        $this->initStorage();
    }

    public function initStorage(): void
    {
        $storageApp = StorageApp::get();
        $storage = $storageApp->getEventStorage();
        $this->storage = $storage;
    }

    /**
     * @param array $event
     * @return mixed
     */
    public function add(array $arData): array
    {
        if (empty($arData['event'])) {
            throw new InvalidArgumentException("Empty key event");
        }
        if (empty($arData['priority'])) {
            throw new InvalidArgumentException("Empty priority");
        }
        if (empty($arData['params'][0])) {
            throw new InvalidArgumentException("Empty params");
        }
        $params = static::sanitizeParams($arData['params']);
        if (!$params) {
            throw new InvalidArgumentException("Empty params");
        }

        $templateData['formData'] = [
            'event' => Helper::sanitize($arData['event']),
            'priority' => (int)Helper::sanitize($arData['priority']),
            'params' => $params,
        ];

        $res = $this->storage->add($arData);
        if ($res === 1) {
            $templateData['message'] = 'Добавили';
        } elseif ($res === 0) {
            $templateData['error'] = 'Такое событие уже есть';
        }
        return $templateData;
    }

    private static function sanitizeParams(array $arParams): array
    {
        $params = [];
        foreach ($arParams as $param) {
            $param = (int)Helper::sanitize($param);
            if ($param > 0) {
                $params[] = (string)$param;
            }
        }
        return $params;
    }

    /**
     * @param int $eventId
     * @return mixed
     */
    public function deleteAll(): array
    {
        $templateData = [];
        $res = $this->storage->deleteAll();

        if ($res === 1) {
            $templateData['message'] = 'Удалили';
        } elseif ($res === 0) {
            $templateData['error'] = 'Удалять нечего';
        }
        return $templateData;
    }

    public function findTopByParams(array $arData): array
    {
        $templateData = [];
        $params = static::sanitizeParams($arData['params']);
        if (!$params) {
            throw new InvalidArgumentException("Empty params");
        }
        $templateData['formData']['params'] = $params;
        $event = $this->storage->findTopByParams($params);
        if ($event) {
            $templateData['message'] = 'Нашли событие';
            $templateData['event'] = $event;
        } else {
            $templateData['error'] = 'По данным параметрам ничего не найдено';
            $templateData['event'] = [];
        }
        return $templateData;
    }

    public function list(): array
    {
        $event = $this->storage->list();
        if ($event) {
            $templateData['message'] = 'События';
            $templateData['list'] = $event;
        } else {
            $templateData['error'] = 'Событий нет';
            $templateData['list'] = [];
        }
        return $templateData;
    }
}
