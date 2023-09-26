-- Выбор всех фильмов на сегодня
select
    *
from
    sessions s
where
    s.start_time >= TO_TIMESTAMP(TO_CHAR(CURRENT_DATE, 'YYYY-MM-DD'), 'YYYY-MM-DD');

-- Подсчёт проданных билетов за неделю
select
    *
from
    tickets t
where
    t.created_at between TO_TIMESTAMP(TO_CHAR(CURRENT_DATE-7, 'YYYY-MM-DD'), 'YYYY-MM-DD') and NOW();

-- Формирование афиши (фильмы, которые показывают сегодня)
-- Поиск 3 самых прибыльных фильмов за неделю
-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
-- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс