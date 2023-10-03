<?php

declare(strict_types=1);

namespace Eevstifeev\Hw12\Views;

class IndexView
{
    public static function notFound(): void
    {
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }

    public static function index(): void
    {
        echo "Выберите корректное действие:";
        echo "<br>";
        echo "<br>";
        echo "<a href=?action=add&priority=100&conditions[param1]=2&conditions[param2]=2&event=event1'>Добавить</a>";
        echo "<br>";
        echo "<br>";
        echo "<a href='?action=getByUuid&uuid=0f98fd41-90d4-4631-a1d5-eca021cfafca'>Найти по UUID</a>";
        echo "<br>";
        echo "<br>";
        echo "<a href='?action=clear&uuid=0f98fd41-90d4-4631-a1d5-eca021cfafca'>Очистить по UUID</a>";
        echo "<br>";
        echo "<br>";
        echo "<a href='?action=clearAll'>Очиститить все</a>";
        echo "<br>";
        echo "<br>";
        echo "<a href='?action=find&params[param1]=2'>Поиск по параметрам</a>";
        echo "<br>";
    }
}
