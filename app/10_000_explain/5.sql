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
-- Sort  (cost=205.58..205.83 rows=100 width=8) (actual time=0.407..0.411 rows=100 loops=1)
-- "  Sort Key: p.""row"", p.number"
--   Sort Method: quicksort  Memory: 28kB
--   ->  Hash Right Join  (cost=3.25..202.26 rows=100 width=8) (actual time=0.378..0.387 rows=100 loops=1)
--         Hash Cond: (t.place_id = p.id)
--         ->  Seq Scan on ticket t  (cost=0.00..199.00 rows=2 width=8) (actual time=0.353..0.353 rows=0 loops=1)
--               Filter: (session_id = 20)
--               Rows Removed by Filter: 10000
--         ->  Hash  (cost=2.00..2.00 rows=100 width=8) (actual time=0.020..0.020 rows=100 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 12kB
--               ->  Seq Scan on place p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.005..0.010 rows=100 loops=1)
-- Planning Time: 0.143 ms
-- Execution Time: 0.431 ms


-- Индекс бля таблицы ticket по полю session_id
CREATE INDEX idx_ticket_session_id ON ticket(session_id);

-- QUERY PLAN
-- Sort  (cost=17.21..17.46 rows=100 width=8) (actual time=0.056..0.059 rows=100 loops=1)
-- "  Sort Key: p.""row"", p.number"
--   Sort Method: quicksort  Memory: 28kB
--   ->  Hash Left Join  (cost=11.36..13.88 rows=100 width=8) (actual time=0.020..0.035 rows=100 loops=1)
--         Hash Cond: (p.id = t.place_id)
--         ->  Seq Scan on place p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.003..0.007 rows=100 loops=1)
--         ->  Hash  (cost=11.34..11.34 rows=2 width=8) (actual time=0.011..0.011 rows=0 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 8kB
--               ->  Bitmap Heap Scan on ticket t  (cost=4.30..11.34 rows=2 width=8) (actual time=0.011..0.011 rows=0 loops=1)
--                     Recheck Cond: (session_id = 20)
--                     ->  Bitmap Index Scan on idx_ticket_session_id  (cost=0.00..4.30 rows=2 width=0) (actual time=0.009..0.009 rows=0 loops=1)
--                           Index Cond: (session_id = 20)
-- Planning Time: 0.183 ms
-- Execution Time: 0.077 ms


-- По результату анализа запроса можно сказать следующее:
--
-- при добавлении индексов, стоимость и время выполнения запроса значительно уменьшились

-- Вывод: применение индекса оправданно
