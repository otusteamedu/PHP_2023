EXPLAIN ANALYSE
SELECT
    rsc.row,
    rsc.seat,
    CASE WHEN t.status = 'book' OR t.status = 'reserved' THEN 0 ELSE 1 END AS busy
FROM
    tickets t
        LEFT JOIN sessions s ON t.session_id = s.id
        LEFT JOIN rows_seats_categories rsc ON t.rows_seats_categories_id = rsc.id
WHERE
    session_id = 1;

-- Hash Left Join  (cost=3.25..192.32 rows=9 width=12) (actual time=0.315..1.372 rows=7 loops=1)
--   Hash Cond: (t.rows_seats_categories_id = rsc.id)
--   ->  Seq Scan on tickets t  (cost=0.00..189.00 rows=9 width=14) (actual time=0.244..1.292 rows=7 loops=1)
--         Filter: (session_id = 1)
--         Rows Removed by Filter: 9993
--   ->  Hash  (cost=2.00..2.00 rows=100 width=12) (actual time=0.059..0.060 rows=100 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 13kB
--         ->  Seq Scan on rows_seats_categories rsc  (cost=0.00..2.00 rows=100 width=12) (actual time=0.006..0.028 rows=100 loops=1)
-- Planning Time: 0.307 ms
-- Execution Time: 1.405 ms

CREATE INDEX idx_session_id ON tickets(session_id);

-- Hash Left Join  (cost=7.60..33.66 rows=9 width=12) (actual time=0.148..0.192 rows=7 loops=1)
--   Hash Cond: (t.rows_seats_categories_id = rsc.id)
--   ->  Bitmap Heap Scan on tickets t  (cost=4.35..30.34 rows=9 width=14) (actual time=0.047..0.083 rows=7 loops=1)
--         Recheck Cond: (session_id = 1)
--         Heap Blocks: exact=7
--         ->  Bitmap Index Scan on idx_session_id  (cost=0.00..4.35 rows=9 width=0) (actual time=0.038..0.039 rows=7 loops=1)
--               Index Cond: (session_id = 1)
--   ->  Hash  (cost=2.00..2.00 rows=100 width=12) (actual time=0.065..0.066 rows=100 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 13kB
--         ->  Seq Scan on rows_seats_categories rsc  (cost=0.00..2.00 rows=100 width=12) (actual time=0.013..0.035 rows=100 loops=1)
-- Planning Time: 0.460 ms
-- Execution Time: 0.234 ms

--Анализ показал, что добавление индекса на поле session_id ускорило выполнение запроса в несколько раз
--Вывод: добавление индекса оправдано

