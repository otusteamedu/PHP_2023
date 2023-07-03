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
-- Sort  (cost=205.58..205.83 rows=100 width=8) (actual time=0.949..0.954 rows=100 loops=1)
--   Sort Key: p."row", p."position"
--   Sort Method: quicksort  Memory: 29kB
--   ->  Hash Right Join  (cost=3.25..202.26 rows=100 width=8) (actual time=0.117..0.892 rows=100 loops=1)
--         Hash Cond: (t.place_id = p.id)
--         ->  Seq Scan on tickets t  (cost=0.00..199.00 rows=2 width=8) (actual time=0.051..0.810 rows=3 loops=1)
--               Filter: (session_id = 40)
--               Rows Removed by Filter: 9997
--         ->  Hash  (cost=2.00..2.00 rows=100 width=8) (actual time=0.042..0.043 rows=100 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 12kB
--               ->  Seq Scan on places p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.007..0.020 rows=100 loops=1)
-- Planning Time: 0.512 ms
-- Execution Time: 0.997 ms

-- Индекс по полю session_id
CREATE INDEX idx_session_id ON tickets(session_id);

-- QUERY PLAN
-- Sort  (cost=17.21..17.46 rows=100 width=8) (actual time=0.158..0.163 rows=100 loops=1)
--   Sort Key: p."row", p."position"
--   Sort Method: quicksort  Memory: 29kB
--   ->  Hash Left Join  (cost=11.36..13.88 rows=100 width=8) (actual time=0.074..0.105 rows=100 loops=1)
--         Hash Cond: (p.id = t.place_id)
--         ->  Seq Scan on places p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.004..0.012 rows=100 loops=1)
--         ->  Hash  (cost=11.34..11.34 rows=2 width=8) (actual time=0.047..0.047 rows=3 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--               ->  Bitmap Heap Scan on tickets t  (cost=4.30..11.34 rows=2 width=8) (actual time=0.024..0.037 rows=3 loops=1)
--                     Recheck Cond: (session_id = 40)
--                     Heap Blocks: exact=3
--                     ->  Bitmap Index Scan on idx_session_id  (cost=0.00..4.30 rows=2 width=0) (actual time=0.014..0.014 rows=3 loops=1)
--                           Index Cond: (session_id = 40)
-- Planning Time: 0.476 ms
-- Execution Time: 0.210 ms


-- Анализ этого запроса показал, что применение индекса
-- - улучшило стоимость получения первой строки и стоимость получения всех строк
-- - значительно снизилось время получения первой и всех строк
-- Вывод: применение индекса по дате покупке оправданно и полезно