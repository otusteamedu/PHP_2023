-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
explain analyse
select
    p.row,
    p.position,
    CASE WHEN t.id is null THEN 0 ELSE 1 END AS busy
from
    places as p
    left join tickets t on (p.id = t.place_id and t.session_id = 40)
order by
    p.row, p.position;

-- QUERY PLAN
-- Sort  (cost=126767.87..126770.35 rows=992 width=8) (actual time=230.304..230.343 rows=1018 loops=1)
--   Sort Key: p."row", p."position"
--   Sort Method: quicksort  Memory: 72kB
--   ->  Hash Right Join  (cost=1003.25..126718.50 rows=992 width=8) (actual time=0.850..229.720 rows=1018 loops=1)
--         Hash Cond: (t.place_id = p.id)
--         ->  Gather  (cost=1000.00..126712.53 rows=992 width=8) (actual time=0.787..232.405 rows=1018 loops=1)
--               Workers Planned: 2
--               Workers Launched: 2
--               ->  Parallel Seq Scan on tickets t  (cost=0.00..125613.33 rows=413 width=8) (actual time=0.422..226.044 rows=339 loops=3)
--                     Filter: (session_id = 40)
--                     Rows Removed by Filter: 3332994
--         ->  Hash  (cost=2.00..2.00 rows=100 width=8) (actual time=0.041..0.042 rows=100 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 12kB
--               ->  Seq Scan on places p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.007..0.020 rows=100 loops=1)
-- Planning Time: 0.482 ms
-- Execution Time: 233.786 ms

-- Индекс по полю session_id
CREATE INDEX idx_session_id ON tickets(session_id);

-- QUERY PLAN
-- Sort  (cost=3689.33..3691.81 rows=992 width=8) (actual time=11.581..11.628 rows=1018 loops=1)
--   Sort Key: p."row", p."position"
--   Sort Method: quicksort  Memory: 72kB
--   ->  Hash Right Join  (cost=23.37..3639.95 rows=992 width=8) (actual time=0.582..11.088 rows=1018 loops=1)
--         Hash Cond: (t.place_id = p.id)
--         ->  Bitmap Heap Scan on tickets t  (cost=20.12..3633.99 rows=992 width=8) (actual time=0.513..10.273 rows=1018 loops=1)
--               Recheck Cond: (session_id = 40)
--               Heap Blocks: exact=1004
--               ->  Bitmap Index Scan on idx_session_id  (cost=0.00..19.87 rows=992 width=0) (actual time=0.381..0.381 rows=1018 loops=1)
--                     Index Cond: (session_id = 40)
--         ->  Hash  (cost=2.00..2.00 rows=100 width=8) (actual time=0.043..0.043 rows=100 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 12kB
--               ->  Seq Scan on places p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.006..0.019 rows=100 loops=1)
-- Planning Time: 0.592 ms
-- Execution Time: 11.734 ms


-- Анализ этого запроса показал, что применение индекса
-- - улучшило стоимость получения первой строки и стоимость получения всех строк
-- - значительно снизилось время получения первой и всех строк
-- Вывод: применение индекса по дате покупке оправданно и полезно