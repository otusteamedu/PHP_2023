<?php

declare(strict_types=1);

namespace Vp\App;

class Message
{
    public const FAILED_CREATE_ENTITY = 'Ошибка! Не удалось добавить запись.';
    public const FAILED_READ_ENTITY = 'Ошибка! Не удалось считать запись.';

    public const SUCCESS_CREATE_DATA = 'Демо-данные успешно добавлены.';
    public const EMPTY_EVENTS = 'Не найдено ни одной записи.';
    public const EMPTY_EVENT = 'Не удалось найти событие по заданным параметрам.';
}
