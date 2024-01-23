-- Формирование афиши (фильмы, которые показывают сегодня)
explain analyse
select
    m.title as movie_name,
    h.name as hall_name,
    s.date,
    s.time
from
    movie m
    join session s on m.id = s.movie_id
    join hall h on s.hall_id = h.id
where
    s.date = CURRENT_DATE
order by
    h.name,
    s.time;

-- QUERY PLAN
-- Sort  (cost=2389.43..2389.52 rows=38 width=269) (actual time=4.197..4.198 rows=0 loops=1)
-- "  Sort Key: h.name, s.""time"""
--   Sort Method: quicksort  Memory: 25kB
--   ->  Nested Loop  (cost=0.44..2388.43 rows=38 width=269) (actual time=4.192..4.193 rows=0 loops=1)
--         ->  Nested Loop  (cost=0.29..2380.50 rows=38 width=55) (actual time=4.191..4.192 rows=0 loops=1)
--               ->  Seq Scan on session s  (cost=0.00..2137.00 rows=38 width=20) (actual time=4.191..4.191 rows=0 loops=1)
--                     Filter: (date = CURRENT_DATE)
--                     Rows Removed by Filter: 100000
--               ->  Index Scan using movie_pkey on movie m  (cost=0.29..6.41 rows=1 width=43) (never executed)
--                     Index Cond: (id = s.movie_id)
--         ->  Memoize  (cost=0.16..1.44 rows=1 width=222) (never executed)
--               Cache Key: s.hall_id
--               Cache Mode: logical
--               ->  Index Scan using hall_pkey on hall h  (cost=0.15..1.43 rows=1 width=222) (never executed)
--                     Index Cond: (id = s.hall_id)
-- Planning Time: 0.175 ms
-- Execution Time: 4.218 ms



-- Добавляем индекс для таблицы session по полю date
CREATE INDEX idx_session_date ON session(date);

-- QUERY PLAN
-- Sort  (cost=378.84..378.93 rows=38 width=269) (actual time=0.013..0.013 rows=0 loops=1)
-- "  Sort Key: h.name, s.""time"""
--   Sort Method: quicksort  Memory: 25kB
--   ->  Nested Loop  (cost=5.03..377.84 rows=38 width=269) (actual time=0.009..0.010 rows=0 loops=1)
--         ->  Nested Loop  (cost=4.87..369.90 rows=38 width=55) (actual time=0.009..0.009 rows=0 loops=1)
--               ->  Bitmap Heap Scan on session s  (cost=4.59..126.41 rows=38 width=20) (actual time=0.009..0.009 rows=0 loops=1)
--                     Recheck Cond: (date = CURRENT_DATE)
--                     ->  Bitmap Index Scan on idx_session_date  (cost=0.00..4.58 rows=38 width=0) (actual time=0.008..0.008 rows=0 loops=1)
--                           Index Cond: (date = CURRENT_DATE)
--               ->  Index Scan using movie_pkey on movie m  (cost=0.29..6.41 rows=1 width=43) (never executed)
--                     Index Cond: (id = s.movie_id)
--         ->  Memoize  (cost=0.16..1.44 rows=1 width=222) (never executed)
--               Cache Key: s.hall_id
--               Cache Mode: logical
--               ->  Index Scan using hall_pkey on hall h  (cost=0.15..1.43 rows=1 width=222) (never executed)
--                     Index Cond: (id = s.hall_id)
-- Planning Time: 0.213 ms
-- Execution Time: 0.032 ms


-- По результату анализа запроса можно сказать следующее:
-- при использовании индекса реальное время выполнения запроса и стоимость в разы меньше. И сопоставимо с этими показателями
-- для 10 000 строк

-- Вывод: применение индекса оправданно
