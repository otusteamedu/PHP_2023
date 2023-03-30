<?php

declare(strict_types=1);

namespace Vp\App\DTO;

class Message
{
    public const FAILED_CREATE_EVENT = 'Ошибка! Не удалось добавить событие.';

    public const SUCCESS_CREATE_EVENT = 'Событие успешно добавлено.';
    public const EMPTY_EVENTS = 'Не найдено ни одной записи.';
    public const EMPTY_EVENT = 'Не удалось найти событие по заданным параметрам.';
}
