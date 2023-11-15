--Подсчёт проданных билетов за неделю
EXPLAIN ANALYSE
SELECT
    count(tickets.id)
FROM
    tickets
        LEFT JOIN sessions ON tickets.session_id = sessions.id
WHERE
    sessions.datetime BETWEEN date_trunc('week', now())
  AND (date_trunc('week', now()) + '6 days 23 hours 59 minutes'::interval)
    AND tickets.status = 'book';

-- Finalize Aggregate  (cost=122167.25..122167.26 rows=1 width=8) (actual time=443.192..447.393 rows=1 loops=1)
--   ->  Gather  (cost=122167.04..122167.25 rows=2 width=8) (actual time=442.952..447.372 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=121167.04..121167.05 rows=1 width=8) (actual time=430.527..430.530 rows=1 loops=3)
--               ->  Hash Join  (cost=1348.10..120765.13 rows=160761 width=4) (actual time=12.266..424.437 rows=129738 loops=3)
--                     Hash Cond: (tickets.session_id = sessions.id)
--                     ->  Parallel Seq Scan on tickets  (cost=0.00..115778.33 rows=1386111 width=8) (actual time=7.553..302.885 rows=1110762 loops=3)
--                           Filter: (status = 'book'::text)
--                           Rows Removed by Filter: 2222571
--                     ->  Hash  (cost=1203.13..1203.13 rows=11598 width=4) (actual time=4.605..4.606 rows=11654 loops=3)
--                           Buckets: 16384  Batches: 1  Memory Usage: 538kB
--                           ->  Bitmap Heap Scan on sessions  (cost=247.18..1203.13 rows=11598 width=4) (actual time=1.382..3.498 rows=11654 loops=3)
-- "                                Recheck Cond: ((datetime >= date_trunc('week'::text, now())) AND (datetime <= (date_trunc('week'::text, now()) + '6 days 23:59:00'::interval)))"
--                                 Heap Blocks: exact=637
--                                 ->  Bitmap Index Scan on idx_session_datetime  (cost=0.00..244.28 rows=11598 width=0) (actual time=1.312..1.312 rows=11654 loops=3)
-- "                                      Index Cond: ((datetime >= date_trunc('week'::text, now())) AND (datetime <= (date_trunc('week'::text, now()) + '6 days 23:59:00'::interval)))"
-- Planning Time: 0.183 ms
-- JIT:
--   Functions: 56
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.180 ms, Inlining 0.000 ms, Optimization 0.962 ms, Emission 21.498 ms, Total 24.640 ms"
-- Execution Time: 448.144 ms

create index ticket_book_status on tickets (status)
    where status = 'book';

-- Finalize Aggregate  (cost=116143.74..116143.75 rows=1 width=8) (actual time=409.320..414.257 rows=1 loops=1)
--   ->  Gather  (cost=116143.53..116143.74 rows=2 width=8) (actual time=408.818..414.233 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=115143.53..115143.54 rows=1 width=8) (actual time=396.155..396.158 rows=1 loops=3)
--               ->  Hash Join  (cost=30081.54..114741.62 rows=160761 width=4) (actual time=83.012..390.142 rows=129738 loops=3)
--                     Hash Cond: (tickets.session_id = sessions.id)
--                     ->  Parallel Bitmap Heap Scan on tickets  (cost=28733.43..109754.82 rows=1386111 width=8) (actual time=70.693..246.756 rows=1110762 loops=3)
--                           Recheck Cond: (status = 'book'::text)
--                           Heap Blocks: exact=22335
--                           ->  Bitmap Index Scan on ticket_book_status  (cost=0.00..27901.76 rows=3326667 width=0) (actual time=72.793..72.794 rows=3332287 loops=1)
--                     ->  Hash  (cost=1203.13..1203.13 rows=11598 width=4) (actual time=12.223..12.224 rows=11654 loops=3)
--                           Buckets: 16384  Batches: 1  Memory Usage: 538kB
--                           ->  Bitmap Heap Scan on sessions  (cost=247.18..1203.13 rows=11598 width=4) (actual time=8.734..11.052 rows=11654 loops=3)
-- "                                Recheck Cond: ((datetime >= date_trunc('week'::text, now())) AND (datetime <= (date_trunc('week'::text, now()) + '6 days 23:59:00'::interval)))"
--                                 Heap Blocks: exact=637
--                                 ->  Bitmap Index Scan on idx_session_datetime  (cost=0.00..244.28 rows=11598 width=0) (actual time=8.661..8.661 rows=11654 loops=3)
-- "                                      Index Cond: ((datetime >= date_trunc('week'::text, now())) AND (datetime <= (date_trunc('week'::text, now()) + '6 days 23:59:00'::interval)))"
-- Planning Time: 0.222 ms
-- JIT:
--   Functions: 56
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.492 ms, Inlining 0.000 ms, Optimization 0.919 ms, Emission 21.010 ms, Total 24.421 ms"
-- Execution Time: 415.044 ms

--Анализ: Создание индекса по полю status ускорило выполнение запроса примерно на 30%, но немного увеличилось время планирования запроса
--Вывод: Создание индекса оправдано