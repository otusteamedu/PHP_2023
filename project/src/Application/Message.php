<?php

declare(strict_types=1);

namespace Vp\App\Application;

class Message
{
    public const FAILED_CREATE_ENTITY = 'Ошибка! Не удалось добавить запись.';
    public const FAILED_ADD_ENTITY = 'Ошибка! Не удалось добавить/обновить запись.';
    public const FAILED_READ_ENTITY = 'Ошибка! Не удалось считать запись.';

    public const SUCCESS_CREATE_DATA = 'Демо-данные успешно добавлены.';
    public const SUCCESS_DATA = 'Найдены записи:';
    public const SUCCESS_ADD = 'Запись успешно добавлена/обновлена';
    public const EMPTY_DATA = 'Не найдено ни одной записи.';
}
