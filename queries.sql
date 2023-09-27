-- Выбор всех фильмов на сегодня
select
    *
from
    sessions s
where
    s.start_time >= TO_TIMESTAMP(TO_CHAR(CURRENT_DATE, 'YYYY-MM-DD'), 'YYYY-MM-DD');

-- Подсчёт проданных билетов за неделю
select
    count(*)
from
    tickets t
where
    t.created_at between TO_TIMESTAMP(TO_CHAR(CURRENT_DATE-7, 'YYYY-MM-DD'), 'YYYY-MM-DD') and NOW();

-- Формирование афиши (фильмы, которые показывают сегодня)
select
    m."name" as "название фильма",
    mg."name" as "жанр",
    mc."name" as "категория"
from
    sessions s
    join movies m on m.id = s.movie_id
    join movie_genres mg on mg.id = m.genre_id
    join movie_categories mc on mc.id = m.category_id
where
    s.start_time >= TO_TIMESTAMP(TO_CHAR(CURRENT_DATE, 'YYYY-MM-DD'), 'YYYY-MM-DD');

-- Поиск 3 самых прибыльных фильмов за неделю
select
    m."name",
    sum(t.price) as summa
from
    tickets t
    join sessions s on s.id = t.session_id
    join movies m on m.id = s.movie_id
where
    t.created_at between TO_TIMESTAMP(TO_CHAR(CURRENT_DATE-7, 'YYYY-MM-DD'), 'YYYY-MM-DD') and NOW()
group by
    m.id
order by
    summa desc
limit 3

-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
select
    sa."row" as "ряд",
    sa.place as "место",
    case
        when t.id is null then 'свободно'
        else 'занято'
    end as "занятость места"
from
    seating_arrangements sa
    join scheme_halls sh on sh.id = sa.scheme_id
    join halls h on h.scheme_id = sh.id
    left join tickets t on t.seating_arrangements_id = sa.id
where
    h.id = 1 -- Для зала №1

-- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
select
    min(t.price),
    max(t.price)
from
    tickets t
    join sessions s on s.id = t.session_id
where
    s.id = 331