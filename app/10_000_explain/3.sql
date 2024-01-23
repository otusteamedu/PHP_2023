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
-- Sort  (cost=264.46..264.47 rows=4 width=269) (actual time=0.427..0.428 rows=0 loops=1)
-- "  Sort Key: h.name, s.""time"""
--   Sort Method: quicksort  Memory: 25kB
--   ->  Hash Join  (cost=17.48..264.42 rows=4 width=269) (actual time=0.422..0.423 rows=0 loops=1)
--         Hash Cond: (s.hall_id = h.id)
--         ->  Nested Loop  (cost=0.29..247.21 rows=4 width=55) (actual time=0.422..0.422 rows=0 loops=1)
--               ->  Seq Scan on session s  (cost=0.00..214.00 rows=4 width=20) (actual time=0.421..0.422 rows=0 loops=1)
--                     Filter: (date = CURRENT_DATE)
--                     Rows Removed by Filter: 10000
--               ->  Index Scan using movie_pkey on movie m  (cost=0.29..8.30 rows=1 width=43) (never executed)
--                     Index Cond: (id = s.movie_id)
--         ->  Hash  (cost=13.20..13.20 rows=320 width=222) (never executed)
--               ->  Seq Scan on hall h  (cost=0.00..13.20 rows=320 width=222) (never executed)
-- Planning Time: 0.169 ms
-- Execution Time: 0.443 ms


-- Добавляем индекс для таблицы session по полю date
CREATE INDEX idx_session_date ON session(date);

-- QUERY PLAN
-- Sort  (cost=66.32..66.33 rows=4 width=269) (actual time=0.017..0.019 rows=0 loops=1)
-- "  Sort Key: h.name, s.""time"""
--   Sort Method: quicksort  Memory: 25kB
--   ->  Nested Loop  (cost=17.71..66.28 rows=4 width=269) (actual time=0.013..0.014 rows=0 loops=1)
--         ->  Hash Join  (cost=17.43..33.07 rows=4 width=234) (actual time=0.013..0.014 rows=0 loops=1)
--               Hash Cond: (h.id = s.hall_id)
--               ->  Seq Scan on hall h  (cost=0.00..13.20 rows=320 width=222) (actual time=0.002..0.002 rows=1 loops=1)
--               ->  Hash  (cost=17.38..17.38 rows=4 width=20) (actual time=0.008..0.009 rows=0 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 8kB
--                     ->  Bitmap Heap Scan on session s  (cost=4.32..17.38 rows=4 width=20) (actual time=0.008..0.008 rows=0 loops=1)
--                           Recheck Cond: (date = CURRENT_DATE)
--                           ->  Bitmap Index Scan on idx_session_date  (cost=0.00..4.32 rows=4 width=0) (actual time=0.007..0.007 rows=0 loops=1)
--                                 Index Cond: (date = CURRENT_DATE)
--         ->  Index Scan using movie_pkey on movie m  (cost=0.29..8.30 rows=1 width=43) (never executed)
--               Index Cond: (id = s.movie_id)
-- Planning Time: 0.208 ms
-- Execution Time: 0.036 ms



-- По результату анализа запроса можно сказать следующее:
-- при использовании индекса стоимость запроса, как и плановое время выполнения уменьшается,
-- но реальное время выполнения запроса уменьшилось еще сильнее

-- Вывод: применение индекса оправданно
