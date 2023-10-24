-- Формирование афиши (фильмы, которые показывают сегодня)
explain analyse
     select
        f.title as film_name,
        h.name as hall_name,
        p.price as price,
        s.time,
        s.day,
        s.year
    from
        films as f
        join sessions s on f.id = s.film_id
        join halls h on s.hall_id = h.id
        join prices p on s.price_id = p.id
    where
        s.day::text = replace(TO_CHAR(CURRENT_DATE, 'day'),' ', '')
        and s.year = EXTRACT(year FROM now())
 order by
        h.name,
        s.time;


-- QUERY PLAN
-- Sort  (cost=471.65..471.66 rows=1 width=263) (actual time=9.943..9.953 rows=209 loops=1)
--   Sort Key: h.name, s."time"
--   Sort Method: quicksort  Memory: 52kB
--   ->  Nested Loop  (cost=0.29..471.64 rows=1 width=263) (actual time=0.092..9.687 rows=209 loops=1)
--         Join Filter: (s.price_id = p.id)
--         Rows Removed by Join Filter: 10076
--         ->  Nested Loop  (cost=0.29..468.39 rows=1 width=263) (actual time=0.084..7.768 rows=209 loops=1)
--               Join Filter: (s.hall_id = h.id)
--               Rows Removed by Join Filter: 298
--               ->  Nested Loop  (cost=0.29..467.30 rows=1 width=49) (actual time=0.079..7.375 rows=209 loops=1)
--                     ->  Seq Scan on sessions s  (cost=0.00..459.00 rows=1 width=26) (actual time=0.061..6.514 rows=209 loops=1)
--                           Filter: (((year)::double precision = date_part('year'::text, now())) AND ((day)::text = replace(to_char((CURRENT_DATE)::timestamp with time zone, 'day'::text), ' '::text, ''::text)))
--                           Rows Removed by Filter: 9791
--                     ->  Index Scan using films_pkey on films f  (cost=0.29..8.30 rows=1 width=31) (actual time=0.003..0.003 rows=1 loops=209)
--                           Index Cond: (id = s.film_id)
--               ->  Seq Scan on halls h  (cost=0.00..1.04 rows=4 width=222) (actual time=0.001..0.001 rows=2 loops=209)
--         ->  Seq Scan on prices p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.002..0.005 rows=49 loops=209)
-- Planning Time: 0.937 ms
-- Execution Time: 10.035 ms


-- Добавил составной индекс по полю day, year
CREATE INDEX idx_day_year ON sessions(day, year);

-- Sort  (cost=471.65..471.66 rows=1 width=263) (actual time=10.949..10.959 rows=209 loops=1)
--   Sort Key: h.name, s."time"
--   Sort Method: quicksort  Memory: 52kB
--   ->  Nested Loop  (cost=0.29..471.64 rows=1 width=263) (actual time=0.087..10.677 rows=209 loops=1)
--         Join Filter: (s.price_id = p.id)
--         Rows Removed by Join Filter: 10076
--         ->  Nested Loop  (cost=0.29..468.39 rows=1 width=263) (actual time=0.080..8.470 rows=209 loops=1)
--               Join Filter: (s.hall_id = h.id)
--               Rows Removed by Join Filter: 298
--               ->  Nested Loop  (cost=0.29..467.30 rows=1 width=49) (actual time=0.075..8.050 rows=209 loops=1)
--                     ->  Seq Scan on sessions s  (cost=0.00..459.00 rows=1 width=26) (actual time=0.057..6.957 rows=209 loops=1)
--                           Filter: (((year)::double precision = date_part('year'::text, now())) AND ((day)::text = replace(to_char((CURRENT_DATE)::timestamp with time zone, 'day'::text), ' '::text, ''::text)))
--                           Rows Removed by Filter: 9791
--                     ->  Index Scan using films_pkey on films f  (cost=0.29..8.30 rows=1 width=31) (actual time=0.004..0.004 rows=1 loops=209)
--                           Index Cond: (id = s.film_id)
--               ->  Seq Scan on halls h  (cost=0.00..1.04 rows=4 width=222) (actual time=0.000..0.001 rows=2 loops=209)
--         ->  Seq Scan on prices p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.002..0.006 rows=49 loops=209)
-- Planning Time: 1.130 ms
-- Execution Time: 11.042 ms


-- Анализ этого запроса показал, что применение индекса
-- - индекс idx_day_year вообще не применился, postgres выбрал оптимальным последовательное чтение данных 
-- - немного снизилось время получения первой строки
-- - так же пробовалал добавлять индекс на поля по которым сортирую - так же без успешно
-- Вывод: применение индекса не оправданно 