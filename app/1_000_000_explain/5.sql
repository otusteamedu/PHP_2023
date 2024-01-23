-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
explain analyse
select p.row,
       p.number,
       CASE WHEN t.id is null THEN 0 ELSE 1 END AS busy
from place p
     left join ticket t
               on (p.id = t.place_id and t.session_id = 20)
order by p.row, p.number;

-- QUERY PLAN
-- Sort  (cost=13578.18..13578.43 rows=100 width=8) (actual time=21.562..25.132 rows=132 loops=1)
-- "  Sort Key: p.""row"", p.number"
--   Sort Method: quicksort  Memory: 29kB
--   ->  Hash Right Join  (cost=1003.25..13574.86 rows=100 width=8) (actual time=0.201..25.093 rows=132 loops=1)
--         Hash Cond: (t.place_id = p.id)
--         ->  Gather  (cost=1000.00..13571.33 rows=100 width=8) (actual time=0.178..25.030 rows=95 loops=1)
--               Workers Planned: 2
--               Workers Launched: 2
--               ->  Parallel Seq Scan on ticket t  (cost=0.00..12561.33 rows=42 width=8) (actual time=0.118..12.378 rows=32 loops=3)
--                     Filter: (session_id = 20)
--                     Rows Removed by Filter: 333302
--         ->  Hash  (cost=2.00..2.00 rows=100 width=8) (actual time=0.019..0.020 rows=100 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 12kB
--               ->  Seq Scan on place p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.004..0.010 rows=100 loops=1)
-- Planning Time: 0.168 ms
-- Execution Time: 25.155 ms



-- Индекс бля таблицы ticket по полю session_id
CREATE INDEX idx_ticket_session_id ON ticket(session_id);

-- QUERY PLAN
-- Sort  (cost=378.31..378.56 rows=100 width=8) (actual time=0.171..0.175 rows=132 loops=1)
-- "  Sort Key: p.""row"", p.number"
--   Sort Method: quicksort  Memory: 29kB
--   ->  Hash Right Join  (cost=8.45..374.99 rows=100 width=8) (actual time=0.048..0.147 rows=132 loops=1)
--         Hash Cond: (t.place_id = p.id)
--         ->  Bitmap Heap Scan on ticket t  (cost=5.20..371.46 rows=100 width=8) (actual time=0.021..0.104 rows=95 loops=1)
--               Recheck Cond: (session_id = 20)
--               Heap Blocks: exact=94
--               ->  Bitmap Index Scan on idx_ticket_session_id  (cost=0.00..5.17 rows=100 width=0) (actual time=0.012..0.012 rows=95 loops=1)
--                     Index Cond: (session_id = 20)
--         ->  Hash  (cost=2.00..2.00 rows=100 width=8) (actual time=0.018..0.018 rows=100 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 12kB
--               ->  Seq Scan on place p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.004..0.009 rows=100 loops=1)
-- Planning Time: 0.182 ms
-- Execution Time: 0.193 ms



-- По результату анализа запроса можно сказать следующее:
-- при добавлении индексов, стоимость и время выполнения запроса значительно уменьшились

-- Вывод: применение индекса оправданно
