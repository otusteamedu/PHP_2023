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
-- Nested Loop  (cost=0.29..467.30 rows=1 width=33) (actual time=0.221..7.101 rows=223 loops=1)
--   ->  Seq Scan on sessions s  (cost=0.00..459.00 rows=1 width=10) (actual time=0.198..6.124 rows=223 loops=1)
--         Filter: (((year)::double precision = date_part('year'::text, now())) AND ((day)::text = replace(to_char((CURRENT_DATE)::timestamp with time zone, 'day'::text), ' '::text, ''::text)))
--         Rows Removed by Filter: 9777
--   ->  Index Scan using films_pkey on films f  (cost=0.29..8.30 rows=1 width=31) (actual time=0.004..0.004 rows=1 loops=223)
--         Index Cond: (id = s.film_id)
-- Planning Time: 0.740 ms
-- Execution Time: 7.163 ms

-- Добавил составной ндекс по полю day, year
CREATE INDEX idx_day_year ON sessions(day, year);

-- QUERY PLAN
-- Nested Loop  (cost=0.29..467.30 rows=1 width=33) (actual time=0.065..7.147 rows=209 loops=1)
--   ->  Seq Scan on sessions s  (cost=0.00..459.00 rows=1 width=10) (actual time=0.048..6.342 rows=209 loops=1)
--         Filter: (((year)::double precision = date_part('year'::text, now())) AND ((day)::text = replace(to_char((CURRENT_DATE)::timestamp with time zone, 'day'::text), ' '::text, ''::text)))
--         Rows Removed by Filter: 9791
--   ->  Index Scan using films_pkey on films f  (cost=0.29..8.30 rows=1 width=31) (actual time=0.003..0.003 rows=1 loops=209)
--         Index Cond: (id = s.film_id)
-- Planning Time: 0.884 ms
-- Execution Time: 7.210 ms


-- Анализ этого запроса показал, что применение индекса
--  - индекс idx_day_year вообще не применился, postgres выбрал оптимальным последовательное чтение данных 
--  - немного снизилось время получения первой строки

-- В таблице sessions время сессии решил разделить на несколько полей - время, день, год. Подумал, что системе будет проще и быстрее 
-- считывать и перебирать данные чем если это было бы в одно поле, например timestamp или datetime - то приходилось мы на лету все подсчитывать

-- Вывод: применение индекса не оправданно 
