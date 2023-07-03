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
-- Sort  (cost=4530.44..4530.45 rows=2 width=263) (actual time=101.073..101.145 rows=2004 loops=1)
--   Sort Key: h.name, s."time"
--   Sort Method: quicksort  Memory: 317kB
--   ->  Nested Loop  (cost=0.29..4530.43 rows=2 width=263) (actual time=58.897..99.825 rows=2004 loops=1)
--         Join Filter: (s.price_id = p.id)
--         Rows Removed by Join Filter: 198396
--         ->  Seq Scan on prices p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.005..0.024 rows=100 loops=1)
--         ->  Materialize  (cost=0.29..4525.44 rows=2 width=263) (actual time=0.004..0.855 rows=2004 loops=100)
--               ->  Nested Loop  (cost=0.29..4525.43 rows=2 width=263) (actual time=0.397..76.457 rows=2004 loops=1)
--                     Join Filter: (s.hall_id = h.id)
--                     Rows Removed by Join Filter: 6012
--                     ->  Seq Scan on halls h  (cost=0.00..13.20 rows=320 width=222) (actual time=0.019..0.021 rows=4 loops=1)
--                     ->  Materialize  (cost=0.29..4502.63 rows=2 width=49) (actual time=0.039..18.830 rows=2004 loops=4)
--                           ->  Nested Loop  (cost=0.29..4502.62 rows=2 width=49) (actual time=0.147..73.850 rows=2004 loops=1)
--                                 ->  Seq Scan on sessions s  (cost=0.00..4486.00 rows=2 width=26) (actual time=0.115..64.652 rows=2004 loops=1)
--                                       Filter: (((year)::double precision = date_part('year'::text, now())) AND ((day)::text = replace(to_char((CURRENT_DATE)::timestamp with time zone, 'day'::text), ' '::text, ''::text)))
--                                       Rows Removed by Filter: 97996
--                                 ->  Index Scan using films_pkey on films f  (cost=0.29..8.31 rows=1 width=31) (actual time=0.004..0.004 rows=1 loops=2004)
--                                       Index Cond: (id = s.film_id)
-- Planning Time: 1.515 ms
-- Execution Time: 101.431 ms


-- Добавил составной индекс по полю day, year
CREATE INDEX idx_day_year ON sessions(day, year);

-- QUERY PLAN
-- Sort  (cost=4530.44..4530.45 rows=2 width=263) (actual time=85.962..86.035 rows=2004 loops=1)
--   Sort Key: h.name, s."time"
--   Sort Method: quicksort  Memory: 317kB
--   ->  Nested Loop  (cost=0.29..4530.43 rows=2 width=263) (actual time=47.197..84.787 rows=2004 loops=1)
--         Join Filter: (s.price_id = p.id)
--         Rows Removed by Join Filter: 198396
--         ->  Seq Scan on prices p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.004..0.023 rows=100 loops=1)
--         ->  Materialize  (cost=0.29..4525.44 rows=2 width=263) (actual time=0.005..0.713 rows=2004 loops=100)
--               ->  Nested Loop  (cost=0.29..4525.43 rows=2 width=263) (actual time=0.473..62.761 rows=2004 loops=1)
--                     Join Filter: (s.hall_id = h.id)
--                     Rows Removed by Join Filter: 6012
--                     ->  Seq Scan on halls h  (cost=0.00..13.20 rows=320 width=222) (actual time=0.002..0.003 rows=4 loops=1)
--                     ->  Materialize  (cost=0.29..4502.63 rows=2 width=49) (actual time=0.013..15.452 rows=2004 loops=4)
--                           ->  Nested Loop  (cost=0.29..4502.62 rows=2 width=49) (actual time=0.047..60.658 rows=2004 loops=1)
--                                 ->  Seq Scan on sessions s  (cost=0.00..4486.00 rows=2 width=26) (actual time=0.033..54.438 rows=2004 loops=1)
--                                       Filter: (((year)::double precision = date_part('year'::text, now())) AND ((day)::text = replace(to_char((CURRENT_DATE)::timestamp with time zone, 'day'::text), ' '::text, ''::text)))
--                                       Rows Removed by Filter: 97996
--                                 ->  Index Scan using films_pkey on films f  (cost=0.29..8.31 rows=1 width=31) (actual time=0.002..0.002 rows=1 loops=2004)
--                                       Index Cond: (id = s.film_id)
-- Planning Time: 1.088 ms
-- Execution Time: 86.341 ms


-- Анализ этого запроса показал, что применение индекса
-- - индекс idx_day_year вообще не применился, postgres выбрал оптимальным последовательное чтение данных 
-- - немного снизилось время получения первой строки и всех строк
-- - так же пробовалал добавлять индекс на поля по которым сортирую - так же без успешно
-- Вывод: применение индекса не оправданно 