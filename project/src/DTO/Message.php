<?php

declare(strict_types=1);

namespace Vp\App\DTO;

class Message
{
    public const FAILED_CREATE_INDEX = 'Ошибка! Не удалось создать индекс %s.';
    public const FAILED_BULK_INDEX = 'Ошибка! Не удалось заполнить индекс %s.';
    public const FAILED_SEARCH_QUERY = 'Ошибка! Не задан поисковый запрос.';

    public const CREATE_INDEX = 'Индекс %s создан. Первоначальное заполнение индекса выполнено.';
    public const EMPTY_HITS = 'Не найдено ни одной записи.';
    public const COUNT_HITS = 'Найдено %s записей.';
}
