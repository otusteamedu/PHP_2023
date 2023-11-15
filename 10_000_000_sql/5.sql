--Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
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

-- Gather  (cost=1003.25..116792.00 rows=101 width=12) (actual time=10.133..164.972 rows=88 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Hash Left Join  (cost=3.25..115781.90 rows=42 width=12) (actual time=8.133..149.135 rows=29 loops=3)
--         Hash Cond: (t.rows_seats_categories_id = rsc.id)
--         ->  Parallel Seq Scan on tickets t  (cost=0.00..115778.33 rows=42 width=14) (actual time=8.011..148.946 rows=29 loops=3)
--               Filter: (session_id = 1)
--               Rows Removed by Filter: 3333304
--         ->  Hash  (cost=2.00..2.00 rows=100 width=12) (actual time=0.042..0.042 rows=100 loops=3)
--               Buckets: 1024  Batches: 1  Memory Usage: 13kB
--               ->  Seq Scan on rows_seats_categories rsc  (cost=0.00..2.00 rows=100 width=12) (actual time=0.022..0.029 rows=100 loops=3)
-- Planning Time: 0.159 ms
-- JIT:
--   Functions: 39
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.524 ms, Inlining 0.000 ms, Optimization 0.898 ms, Emission 18.207 ms, Total 21.629 ms"
-- Execution Time: 166.488 ms

create index idx_session_id ON tickets(session_id);

create index ticket_reserved_status ON tickets(status)
where status = 'reserved';

create index ticket_book_status ON tickets(status)
    where status = 'book';

-- Hash Left Join  (cost=8.47..402.45 rows=101 width=12) (actual time=0.045..0.128 rows=88 loops=1)
--   Hash Cond: (t.rows_seats_categories_id = rsc.id)
--   ->  Bitmap Heap Scan on tickets t  (cost=5.22..398.41 rows=101 width=14) (actual time=0.018..0.083 rows=88 loops=1)
--         Recheck Cond: (session_id = 1)
--         Heap Blocks: exact=88
--         ->  Bitmap Index Scan on idx_session_id  (cost=0.00..5.19 rows=101 width=0) (actual time=0.009..0.009 rows=88 loops=1)
--               Index Cond: (session_id = 1)
--   ->  Hash  (cost=2.00..2.00 rows=100 width=12) (actual time=0.022..0.022 rows=100 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 13kB
--         ->  Seq Scan on rows_seats_categories rsc  (cost=0.00..2.00 rows=100 width=12) (actual time=0.003..0.011 rows=100 loops=1)
-- Planning Time: 0.131 ms
-- Execution Time: 0.148 ms

--Анализ показал, что добавление индекса на поле session_id и частичных индексов на поле status улучшило выполнение запроса со 166 мс до 0.148
--Вывод: добавление индексов оправдано и полезно