-- Выбор всех фильмов на сегодня
explain analyse
select
    m.title,
    s.date
from
    movie m
    join session s on m.id = s.movie_id
where
    s.date = CURRENT_DATE;

-- QUERY PLAN
-- Hash Join  (cost=215.34..385.00 rows=50 width=520) (actual time=0.546..0.547 rows=0 loops=1)
--   Hash Cond: (m.id = s.movie_id)
--   ->  Seq Scan on movie m  (cost=0.00..153.68 rows=1768 width=520) (actual time=0.006..0.006 rows=1 loops=1)
--   ->  Hash  (cost=214.72..214.72 rows=50 width=8) (actual time=0.537..0.537 rows=0 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 8kB
--         ->  Seq Scan on session s  (cost=0.00..214.72 rows=50 width=8) (actual time=0.537..0.537 rows=0 loops=1)
--               Filter: (date = CURRENT_DATE)
--               Rows Removed by Filter: 10000
-- Planning Time: 0.136 ms
-- Execution Time: 0.560 ms


-- Добавил индекс для таблицы session по полю date
CREATE INDEX idx_session_date ON session(date);

-- QUERY PLAN
-- Nested Loop  (cost=4.60..50.59 rows=4 width=43) (actual time=0.009..0.009 rows=0 loops=1)
--   ->  Bitmap Heap Scan on session s  (cost=4.32..17.38 rows=4 width=8) (actual time=0.008..0.009 rows=0 loops=1)
--         Recheck Cond: (date = CURRENT_DATE)
--         ->  Bitmap Index Scan on idx_session_date  (cost=0.00..4.32 rows=4 width=0) (actual time=0.007..0.008 rows=0 loops=1)
--               Index Cond: (date = CURRENT_DATE)
--   ->  Index Scan using movie_pkey on movie m  (cost=0.29..8.30 rows=1 width=43) (never executed)
--         Index Cond: (id = s.movie_id)
-- Planning Time: 0.232 ms
-- Execution Time: 0.022 ms



-- По результату анализа запроса можно сказать следующее:
-- при использовании индекса плановое время немного увеличилось, однако стоимость запроса
-- и реальное время выполнения запроса уменьшилось в разы

-- Вывод: применение индекса оправданно
