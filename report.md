### 1)  
Таблицы заполнены данными из файла `insert_data.php`.  
Выполним запросы и посмотрим их планы.  

```
-- Выбор всех фильмов на сегодня
select
    *
from
    sessions s
where
    s.start_time >= TO_TIMESTAMP(TO_CHAR(CURRENT_DATE, 'YYYY-MM-DD'), 'YYYY-MM-DD');
```

|id |hall_id|movie_id|type_id|start_time             |end_time               |updated_at|created_at             |
|---|-------|--------|-------|-----------------------|-----------------------|----------|-----------------------|
|1  |1      |801     |2      |2023-10-09 20:16:30.056|2023-09-10 19:41:09.114|          |2023-09-26 23:08:15.943|
|13 |1      |86      |1      |2023-09-30 02:47:36.284|2023-09-23 09:03:02.967|          |2023-09-26 23:08:15.943|
|14 |1      |911     |1      |2023-10-01 06:40:56.459|2023-09-28 19:16:37.737|          |2023-09-26 23:08:15.943|
|16 |2      |701     |1      |2023-10-14 01:30:18.944|2023-10-07 13:25:43.507|          |2023-09-26 23:08:15.943|

|count|
|-----|
|407  |

```
-- Выбор всех фильмов на сегодня
explain select
    *
from
    sessions s
where
    s.start_time >= TO_TIMESTAMP(TO_CHAR(CURRENT_DATE, 'YYYY-MM-DD'), 'YYYY-MM-DD');
```
|QUERY PLAN                                                                                                                       |
|---------------------------------------------------------------------------------------------------------------------------------|
|Seq Scan on sessions s  (cost=0.00..31.50 rows=411 width=48)                                                                     |
|  Filter: (start_time >= to_timestamp(to_char((CURRENT_DATE)::timestamp with time zone, 'YYYY-MM-DD'::text), 'YYYY-MM-DD'::text))|

Имеем последовательное сканирование.   

--- 
```
-- Подсчёт проданных билетов за неделю
select
    count(*)
from
    tickets t
where
    t.created_at between TO_TIMESTAMP(TO_CHAR(CURRENT_DATE-7, 'YYYY-MM-DD'), 'YYYY-MM-DD') and NOW();
```
|count|
|-----|
|45   |

```
-- Подсчёт проданных билетов за неделю
explain select
    count(*)
from
    tickets t
where
    t.created_at between TO_TIMESTAMP(TO_CHAR(CURRENT_DATE-7, 'YYYY-MM-DD'), 'YYYY-MM-DD') and NOW();
```
|QUERY PLAN                                                                                                                                                               |
|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
|Aggregate  (cost=39.71..39.72 rows=1 width=8)                                                                                                                            |
|  ->  Seq Scan on tickets t  (cost=0.00..39.70 rows=5 width=0)                                                                                                           |
|        Filter: ((created_at <= now()) AND (created_at >= to_timestamp(to_char(((CURRENT_DATE - 7))::timestamp with time zone, 'YYYY-MM-DD'::text), 'YYYY-MM-DD'::text)))|
Имеем последовательное сканирование.

--- 

```
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
```
|название фильма|жанр            |категория       |
|---------------|----------------|----------------|
|fU2Cbx         |name_2_movie_gen|name_1_movie_cat|
|0RtddW9A       |name_1_movie_gen|name_1_movie_cat|
|otOAQ          |name_2_movie_gen|name_1_movie_cat|
|bkG4R          |name_2_movie_gen|name_2_movie_cat|

|count|
|-----|
|407  |

```
-- Формирование афиши (фильмы, которые показывают сегодня)
explain select 
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
```
|QUERY PLAN                                                                                                                                         |
|---------------------------------------------------------------------------------------------------------------------------------------------------|
|Hash Join  (cost=57.35..92.15 rows=411 width=1038)                                                                                                 |
|  Hash Cond: (m.category_id = mc.id)                                                                                                               |
|  ->  Hash Join  (cost=44.42..78.12 rows=411 width=526)                                                                                            |
|        Hash Cond: (m.genre_id = mg.id)                                                                                                            |
|        ->  Hash Join  (cost=31.50..64.08 rows=411 width=14)                                                                                       |
|              Hash Cond: (s.movie_id = m.id)                                                                                                       |
|              ->  Seq Scan on sessions s  (cost=0.00..31.50 rows=411 width=4)                                                                      |
|                    Filter: (start_time >= to_timestamp(to_char((CURRENT_DATE)::timestamp with time zone, 'YYYY-MM-DD'::text), 'YYYY-MM-DD'::text))|
|              ->  Hash  (cost=19.00..19.00 rows=1000 width=18)                                                                                     |
|                    ->  Seq Scan on movies m  (cost=0.00..19.00 rows=1000 width=18)                                                                |
|        ->  Hash  (cost=11.30..11.30 rows=130 width=520)                                                                                           |
|              ->  Seq Scan on movie_genres mg  (cost=0.00..11.30 rows=130 width=520)                                                               |
|  ->  Hash  (cost=11.30..11.30 rows=130 width=520)                                                                                                 |
|        ->  Seq Scan on movie_categories mc  (cost=0.00..11.30 rows=130 width=520)                                                                 |

Имеем последовательное сканирование двух самых объемных таблиц: movies, sessions

--- 
```
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
```
|name      |summa|
|----------|-----|
|jnRE1h    |957  |
|Hw1z1bdZoA|500  |
|pzWCNj    |499  |

```
-- Поиск 3 самых прибыльных фильмов за неделю
explain select
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
```
|QUERY PLAN                                                                                                                                                                                                   |
|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
|Limit  (cost=66.46..66.47 rows=3 width=552)                                                                                                                                                                  |
|  ->  Sort  (cost=66.46..66.47 rows=5 width=552)                                                                                                                                                             |
|        Sort Key: (sum(t.price)) DESC                                                                                                                                                                        |
|        ->  GroupAggregate  (cost=66.30..66.40 rows=5 width=552)                                                                                                                                             |
|              Group Key: m.id                                                                                                                                                                                |
|              ->  Sort  (cost=66.30..66.31 rows=5 width=534)                                                                                                                                                 |
|                    Sort Key: m.id                                                                                                                                                                           |
|                    ->  Nested Loop  (cost=40.03..66.24 rows=5 width=534)                                                                                                                                    |
|                          ->  Hash Join  (cost=39.76..64.53 rows=5 width=18)                                                                                                                                 |
|                                Hash Cond: (s.id = t.session_id)                                                                                                                                             |
|                                ->  Seq Scan on sessions s  (cost=0.00..20.70 rows=1070 width=8)                                                                                                             |
|                                ->  Hash  (cost=39.70..39.70 rows=5 width=18)                                                                                                                                |
|                                      ->  Seq Scan on tickets t  (cost=0.00..39.70 rows=5 width=18)                                                                                                          |
|                                            Filter: ((created_at <= now()) AND (created_at >= to_timestamp(to_char(((CURRENT_DATE - 7))::timestamp with time zone, 'YYYY-MM-DD'::text), 'YYYY-MM-DD'::text)))|
|                          ->  Index Scan using movies_pkey on movies m  (cost=0.27..0.34 rows=1 width=520)                                                                                                   |
|                                Index Cond: (id = s.movie_id)                                                                                                                                                |


Имеем последовательное сканирование всех таблиц

--- 
```
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
```
|ряд|место|занятость места|
|---|-----|---------------|
|2  |4    |занято         |
|2  |4    |занято         |
|2  |4    |занято         |

|count|
|-----|
|46   |

```
-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
explain select 
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
```
|QUERY PLAN                                                                                            |
|------------------------------------------------------------------------------------------------------|
|Nested Loop  (cost=34.50..59.22 rows=10 width=40)                                                     |
|  ->  Hash Right Join  (cost=34.36..58.02 rows=6 width=20)                                            |
|        Hash Cond: (t.seating_arrangements_id = sa.id)                                                |
|        ->  Seq Scan on tickets t  (cost=0.00..19.90 rows=990 width=8)                                |
|        ->  Hash  (cost=34.28..34.28 rows=6 width=20)                                                 |
|              ->  Hash Join  (cost=8.18..34.28 rows=6 width=20)                                       |
|                    Hash Cond: (sa.scheme_id = h.scheme_id)                                           |
|                    ->  Seq Scan on seating_arrangements sa  (cost=0.00..22.70 rows=1270 width=16)    |
|                    ->  Hash  (cost=8.17..8.17 rows=1 width=4)                                        |
|                          ->  Index Scan using halls_pkey on halls h  (cost=0.15..8.17 rows=1 width=4)|
|                                Index Cond: (id = 1)                                                  |
|  ->  Index Only Scan using scheme_halls_pkey on scheme_halls sh  (cost=0.14..0.20 rows=1 width=4)    |
|        Index Cond: (id = sa.scheme_id)                                                               |

--- 
```
-- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
select
    min(t.price),
    max(t.price)
from
    tickets t
    join sessions s on s.id = t.session_id
where
    s.id = 331
```
|min|max|
|---|---|
|451|451|

```
-- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
explain select
    min(t.price),
    max(t.price)
from
    tickets t
    join sessions s on s.id = t.session_id
where
    s.id = 331
```
|QUERY PLAN                                                                                     |
|-----------------------------------------------------------------------------------------------|
|Aggregate  (cost=30.74..30.75 rows=1 width=64)                                                 |
|  ->  Nested Loop  (cost=0.28..30.72 rows=5 width=14)                                          |
|        ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.28..8.29 rows=1 width=4)|
|              Index Cond: (id = 331)                                                           |
|        ->  Seq Scan on tickets t  (cost=0.00..22.38 rows=5 width=18)                          |
|              Filter: (session_id = 331)                                                       |

### 2)  

Увеличим кол-во sessions на 100к.  
```
-- Выбор всех фильмов на сегодня
explain select
    *
from
    sessions s
where
    s.start_time >= TO_TIMESTAMP(TO_CHAR(CURRENT_DATE, 'YYYY-MM-DD'), 'YYYY-MM-DD');
```
|QUERY PLAN                                                                                                                       |
|---------------------------------------------------------------------------------------------------------------------------------|
|Seq Scan on sessions s  (cost=0.00..3114.50 rows=41411 width=48)                                                                 |
|  Filter: (start_time >= to_timestamp(to_char((CURRENT_DATE)::timestamp with time zone, 'YYYY-MM-DD'::text), 'YYYY-MM-DD'::text))|

Стоимость увеличилась значительно, по сравнению с первым планом.

--- 

Увеличим кол-во tickets на 100к. 
```
-- Подсчёт проданных билетов за неделю
explain select
    count(*)
from
    tickets t
where
    t.created_at between TO_TIMESTAMP(TO_CHAR(CURRENT_DATE-7, 'YYYY-MM-DD'), 'YYYY-MM-DD') and NOW();
```
|QUERY PLAN                                                                                                                                                               |
|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
|Aggregate  (cost=4186.46..4186.47 rows=1 width=8)                                                                                                                        |
|  ->  Seq Scan on tickets t  (cost=0.00..3936.35 rows=100045 width=0)                                                                                                    |
|        Filter: ((created_at <= now()) AND (created_at >= to_timestamp(to_char(((CURRENT_DATE - 7))::timestamp with time zone, 'YYYY-MM-DD'::text), 'YYYY-MM-DD'::text)))|

Видим значительное увеличение стоимости.  

---  

sessions раннее увеличили, проверим следующий план  
```
-- Формирование афиши (фильмы, которые показывают сегодня)
explain select 
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
```
|QUERY PLAN                                                                                                                                         |
|---------------------------------------------------------------------------------------------------------------------------------------------------|
|Hash Join  (cost=57.35..3505.52 rows=41411 width=1038)                                                                                             |
|  Hash Cond: (m.category_id = mc.id)                                                                                                               |
|  ->  Hash Join  (cost=44.42..3380.34 rows=41411 width=526)                                                                                        |
|        Hash Cond: (m.genre_id = mg.id)                                                                                                            |
|        ->  Hash Join  (cost=31.50..3255.16 rows=41411 width=14)                                                                                   |
|              Hash Cond: (s.movie_id = m.id)                                                                                                       |
|              ->  Seq Scan on sessions s  (cost=0.00..3114.50 rows=41411 width=4)                                                                  |
|                    Filter: (start_time >= to_timestamp(to_char((CURRENT_DATE)::timestamp with time zone, 'YYYY-MM-DD'::text), 'YYYY-MM-DD'::text))|
|              ->  Hash  (cost=19.00..19.00 rows=1000 width=18)                                                                                     |
|                    ->  Seq Scan on movies m  (cost=0.00..19.00 rows=1000 width=18)                                                                |
|        ->  Hash  (cost=11.30..11.30 rows=130 width=520)                                                                                           |
|              ->  Seq Scan on movie_genres mg  (cost=0.00..11.30 rows=130 width=520)                                                               |
|  ->  Hash  (cost=11.30..11.30 rows=130 width=520)                                                                                                 |
|        ->  Seq Scan on movie_categories mc  (cost=0.00..11.30 rows=130 width=520)                                                                 |

Фиксируем значительное повыщение стоимости.  

--- 
На фоне увеличения tickets и sessions выполняем
```
-- Поиск 3 самых прибыльных фильмов за неделю
explain select
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
```
|QUERY PLAN                                                                                                                                                                                       |
|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
|Limit  (cost=9902.36..9902.37 rows=3 width=43)                                                                                                                                                   |
|  ->  Sort  (cost=9902.36..9904.86 rows=1000 width=43)                                                                                                                                           |
|        Sort Key: (sum(t.price)) DESC                                                                                                                                                            |
|        ->  HashAggregate  (cost=9876.93..9889.43 rows=1000 width=43)                                                                                                                            |
|              Group Key: m.id                                                                                                                                                                    |
|              ->  Hash Join  (cost=3541.00..9376.71 rows=100045 width=16)                                                                                                                        |
|                    Hash Cond: (s.movie_id = m.id)                                                                                                                                               |
|                    ->  Hash Join  (cost=3509.50..9081.48 rows=100045 width=9)                                                                                                                   |
|                          Hash Cond: (t.session_id = s.id)                                                                                                                                       |
|                          ->  Seq Scan on tickets t  (cost=0.00..3936.35 rows=100045 width=9)                                                                                                    |
|                                Filter: ((created_at <= now()) AND (created_at >= to_timestamp(to_char(((CURRENT_DATE - 7))::timestamp with time zone, 'YYYY-MM-DD'::text), 'YYYY-MM-DD'::text)))|
|                          ->  Hash  (cost=1852.00..1852.00 rows=101000 width=8)                                                                                                                  |
|                                ->  Seq Scan on sessions s  (cost=0.00..1852.00 rows=101000 width=8)                                                                                             |
|                    ->  Hash  (cost=19.00..19.00 rows=1000 width=11)                                                                                                                             |
|                          ->  Seq Scan on movies m  (cost=0.00..19.00 rows=1000 width=11)                                                                                                        |


Ожидаемый результат, фиксируем увеличение стоимости.  

--- 
На фоне увеличения tickets выполняем
```
-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
explain select 
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
```
|QUERY PLAN                                                                                                    |
|--------------------------------------------------------------------------------------------------------------|
|Hash Right Join  (cost=35.61..2354.11 rows=788 width=40)                                                      |
|  Hash Cond: (t.seating_arrangements_id = sa.id)                                                              |
|  ->  Seq Scan on tickets t  (cost=0.00..1935.45 rows=100045 width=8)                                         |
|  ->  Hash  (cost=35.48..35.48 rows=10 width=12)                                                              |
|        ->  Nested Loop  (cost=8.32..35.48 rows=10 width=12)                                                  |
|              ->  Hash Join  (cost=8.18..34.28 rows=6 width=20)                                               |
|                    Hash Cond: (sa.scheme_id = h.scheme_id)                                                   |
|                    ->  Seq Scan on seating_arrangements sa  (cost=0.00..22.70 rows=1270 width=16)            |
|                    ->  Hash  (cost=8.17..8.17 rows=1 width=4)                                                |
|                          ->  Index Scan using halls_pkey on halls h  (cost=0.15..8.17 rows=1 width=4)        |
|                                Index Cond: (id = 1)                                                          |
|              ->  Index Only Scan using scheme_halls_pkey on scheme_halls sh  (cost=0.14..0.20 rows=1 width=4)|
|                    Index Cond: (id = sa.scheme_id)                                                           |

Ожидаемый результат, фиксируем увеличение стоимости.  

--- 
На фоне увеличения tickets и sessions выполняем
```
-- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
explain select
    min(t.price),
    max(t.price)
from
    tickets t
    join sessions s on s.id = t.session_id
where
    s.id = 331
```
|QUERY PLAN                                                                                     |
|-----------------------------------------------------------------------------------------------|
|Aggregate  (cost=2195.37..2195.38 rows=1 width=64)                                             |
|  ->  Nested Loop  (cost=0.29..2194.87 rows=100 width=5)                                       |
|        ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.29..8.31 rows=1 width=4)|
|              Index Cond: (id = 331)                                                           |
|        ->  Seq Scan on tickets t  (cost=0.00..2185.56 rows=100 width=9)                       |
|              Filter: (session_id = 331)                                                       |

Результат аналогичный.  

### 3)  
tickets и sessions увеличиваем до 1000000 записей.  
Проверим планы в том же порядке.

```
 -- Выбор всех фильмов на сегодня
explain select
    *
from
    sessions s
where
    s.start_time >= TO_TIMESTAMP(TO_CHAR(CURRENT_DATE, 'YYYY-MM-DD'), 'YYYY-MM-DD');
```

|QUERY PLAN                                                                                                                       |
|---------------------------------------------------------------------------------------------------------------------------------|
|Seq Scan on sessions s  (cost=0.00..33947.50 rows=451411 width=48)                                                               |
|  Filter: (start_time >= to_timestamp(to_char((CURRENT_DATE)::timestamp with time zone, 'YYYY-MM-DD'::text), 'YYYY-MM-DD'::text))|


```
-- Подсчёт проданных билетов за неделю
explain select
    count(*)
from
    tickets t
where
    t.created_at between TO_TIMESTAMP(TO_CHAR(CURRENT_DATE-7, 'YYYY-MM-DD'), 'YYYY-MM-DD') and NOW();
```

|QUERY PLAN                                                                                                                                                                           |
|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
|Finalize Aggregate  (cost=26177.62..26177.63 rows=1 width=8)                                                                                                                         |
|  ->  Gather  (cost=26177.40..26177.61 rows=2 width=8)                                                                                                                               |
|        Workers Planned: 2                                                                                                                                                           |
|        ->  Partial Aggregate  (cost=25177.40..25177.41 rows=1 width=8)                                                                                                              |
|              ->  Parallel Seq Scan on tickets t  (cost=0.00..24031.56 rows=458337 width=0)                                                                                          |
|                    Filter: ((created_at <= now()) AND (created_at >= to_timestamp(to_char(((CURRENT_DATE - 7))::timestamp with time zone, 'YYYY-MM-DD'::text), 'YYYY-MM-DD'::text)))|

```
-- Формирование афиши (фильмы, которые показывают сегодня)
explain select 
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
```

|QUERY PLAN                                                                                                                                         |
|---------------------------------------------------------------------------------------------------------------------------------------------------|
|Hash Join  (cost=57.35..37641.98 rows=451411 width=1038)                                                                                           |
|  Hash Cond: (m.category_id = mc.id)                                                                                                               |
|  ->  Hash Join  (cost=44.42..36405.48 rows=451411 width=526)                                                                                      |
|        Hash Cond: (m.genre_id = mg.id)                                                                                                            |
|        ->  Hash Join  (cost=31.50..35168.97 rows=451411 width=14)                                                                                 |
|              Hash Cond: (s.movie_id = m.id)                                                                                                       |
|              ->  Seq Scan on sessions s  (cost=0.00..33947.50 rows=451411 width=4)                                                                |
|                    Filter: (start_time >= to_timestamp(to_char((CURRENT_DATE)::timestamp with time zone, 'YYYY-MM-DD'::text), 'YYYY-MM-DD'::text))|
|              ->  Hash  (cost=19.00..19.00 rows=1000 width=18)                                                                                     |
|                    ->  Seq Scan on movies m  (cost=0.00..19.00 rows=1000 width=18)                                                                |
|        ->  Hash  (cost=11.30..11.30 rows=130 width=520)                                                                                           |
|              ->  Seq Scan on movie_genres mg  (cost=0.00..11.30 rows=130 width=520)                                                               |
|  ->  Hash  (cost=11.30..11.30 rows=130 width=520)                                                                                                 |
|        ->  Seq Scan on movie_categories mc  (cost=0.00..11.30 rows=130 width=520)                                                                 |


```
-- Поиск 3 самых прибыльных фильмов за неделю
explain select
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
```
|QUERY PLAN                                                                                                                                                                                                         |
|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
|Limit  (cost=57657.54..57657.55 rows=3 width=43)                                                                                                                                                                   |
|  ->  Sort  (cost=57657.54..57660.04 rows=1000 width=43)                                                                                                                                                           |
|        Sort Key: (sum(t.price)) DESC                                                                                                                                                                              |
|        ->  Finalize GroupAggregate  (cost=57383.77..57644.62 rows=1000 width=43)                                                                                                                                  |
|              Group Key: m.id                                                                                                                                                                                      |
|              ->  Gather Merge  (cost=57383.77..57617.12 rows=2000 width=43)                                                                                                                                       |
|                    Workers Planned: 2                                                                                                                                                                             |
|                    ->  Sort  (cost=56383.75..56386.25 rows=1000 width=43)                                                                                                                                         |
|                          Sort Key: m.id                                                                                                                                                                           |
|                          ->  Partial HashAggregate  (cost=56321.42..56333.92 rows=1000 width=43)                                                                                                                  |
|                                Group Key: m.id                                                                                                                                                                    |
|                                ->  Hash Join  (cost=21316.28..54029.61 rows=458361 width=16)                                                                                                                      |
|                                      Hash Cond: (s.movie_id = m.id)                                                                                                                                               |
|                                      ->  Parallel Hash Join  (cost=21284.78..52789.82 rows=458361 width=9)                                                                                                        |
|                                            Hash Cond: (t.session_id = s.id)                                                                                                                                       |
|                                            ->  Parallel Seq Scan on tickets t  (cost=0.00..24031.84 rows=458361 width=9)                                                                                          |
|                                                  Filter: ((created_at <= now()) AND (created_at >= to_timestamp(to_char(((CURRENT_DATE - 7))::timestamp with time zone, 'YYYY-MM-DD'::text), 'YYYY-MM-DD'::text)))|
|                                            ->  Parallel Hash  (cost=13760.68..13760.68 rows=458568 width=8)                                                                                                       |
|                                                  ->  Parallel Seq Scan on sessions s  (cost=0.00..13760.68 rows=458568 width=8)                                                                                   |
|                                      ->  Hash  (cost=19.00..19.00 rows=1000 width=11)                                                                                                                             |
|                                            ->  Seq Scan on movies m  (cost=0.00..19.00 rows=1000 width=11)                                                                                                        |


```
   
-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
explain select 
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
```

|QUERY PLAN                                                                                                    |
|--------------------------------------------------------------------------------------------------------------|
|Hash Right Join  (cost=35.61..25528.85 rows=8662 width=40)                                                    |
|  Hash Cond: (t.seating_arrangements_id = sa.id)                                                              |
|  ->  Seq Scan on tickets t  (cost=0.00..21281.45 rows=1100045 width=8)                                       |
|  ->  Hash  (cost=35.48..35.48 rows=10 width=12)                                                              |
|        ->  Nested Loop  (cost=8.32..35.48 rows=10 width=12)                                                  |
|              ->  Hash Join  (cost=8.18..34.28 rows=6 width=20)                                               |
|                    Hash Cond: (sa.scheme_id = h.scheme_id)                                                   |
|                    ->  Seq Scan on seating_arrangements sa  (cost=0.00..22.70 rows=1270 width=16)            |
|                    ->  Hash  (cost=8.17..8.17 rows=1 width=4)                                                |
|                          ->  Index Scan using halls_pkey on halls h  (cost=0.15..8.17 rows=1 width=4)        |
|                                Index Cond: (id = 1)                                                          |
|              ->  Index Only Scan using scheme_halls_pkey on scheme_halls sh  (cost=0.14..0.20 rows=1 width=4)|
|                    Index Cond: (id = sa.scheme_id)                                                           |

```
-- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
explain select
    min(t.price),
    max(t.price)
from
    tickets t
    join sessions s on s.id = t.session_id
where
    s.id = 331
```

|QUERY PLAN                                                                                     |
|-----------------------------------------------------------------------------------------------|
|Aggregate  (cost=17145.35..17145.36 rows=1 width=64)                                           |
|  ->  Nested Loop  (cost=1000.43..17139.85 rows=1100 width=5)                                  |
|        ->  Index Only Scan using sessions_pkey on sessions s  (cost=0.43..8.45 rows=1 width=4)|
|              Index Cond: (id = 331)                                                           |
|        ->  Gather  (cost=1000.00..17120.40 rows=1100 width=9)                                 |
|              Workers Planned: 2                                                               |
|              ->  Parallel Seq Scan on tickets t  (cost=0.00..16010.40 rows=458 width=9)       |
|                    Filter: (session_id = 331)                                                 |


### 4)  

Приступаем к оптимизации.  

Для таблицы sessions будет уместным добавить индекс для поля 