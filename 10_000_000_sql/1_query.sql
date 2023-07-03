-- Выбор всех фильмов на сегодня
explain analyse
    select
        f.title,
        s.day,
        s.year
    from
        films as f
        join sessions s on f.id = s.film_id
    where
        s.day::text = replace(TO_CHAR(CURRENT_DATE, 'day'),' ', '')
        and s.year = EXTRACT(year FROM now());

-- QUERY PLAN
-- Nested Loop  (cost=0.29..4502.62 rows=2 width=33) (actual time=0.143..80.660 rows=2004 loops=1)
--   ->  Seq Scan on sessions s  (cost=0.00..4486.00 rows=2 width=10) (actual time=0.118..69.610 rows=2004 loops=1)
--         Filter: (((year)::double precision = date_part('year'::text, now())) AND ((day)::text = replace(to_char((CURRENT_DATE)::timestamp with time zone, 'day'::text), ' '::text, ''::text)))
--         Rows Removed by Filter: 97996
--   ->  Index Scan using films_pkey on films f  (cost=0.29..8.31 rows=1 width=31) (actual time=0.004..0.004 rows=1 loops=2004)
--         Index Cond: (id = s.film_id)
-- Planning Time: 0.883 ms
-- Execution Time: 80.888 ms

-- Добавил составной ндекс по полю day, year
CREATE INDEX idx_day_year ON sessions(day, year);

-- QUERY PLAN
-- Nested Loop  (cost=0.29..4502.62 rows=2 width=33) (actual time=0.070..59.272 rows=2004 loops=1)
--   ->  Seq Scan on sessions s  (cost=0.00..4486.00 rows=2 width=10) (actual time=0.058..53.745 rows=2004 loops=1)
--         Filter: (((year)::double precision = date_part('year'::text, now())) AND ((day)::text = replace(to_char((CURRENT_DATE)::timestamp with time zone, 'day'::text), ' '::text, ''::text)))
--         Rows Removed by Filter: 97996
--   ->  Index Scan using films_pkey on films f  (cost=0.29..8.31 rows=1 width=31) (actual time=0.002..0.002 rows=1 loops=2004)
--         Index Cond: (id = s.film_id)
-- Planning Time: 1.301 ms
-- Execution Time: 59.454 ms


-- Анализ этого запроса показал, что применение индекса
--  - индекс idx_day_year вообще не применился, postgres выбрал оптимальным последовательное чтение данных 
--  - немного снизилось время получения первой строки

-- В таблице sessions время сессии решил разделить на несколько полей - время, день, год. Подумал, что системе будет проще и быстрее 
-- считывать и перебирать данные чем если это было бы в одно поле, например timestamp или datetime - то приходилось мы на лету все подсчитывать

-- Вывод: применение индекса не оправданно 
