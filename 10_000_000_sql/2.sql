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

-- Finalize Aggregate  (cost=122225.89..122225.90 rows=1 width=8) (actual time=450.436..453.954 rows=1 loops=1)
--   ->  Gather  (cost=122225.68..122225.89 rows=2 width=8) (actual time=450.232..453.937 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=121225.68..121225.69 rows=1 width=8) (actual time=437.792..437.794 rows=1 loops=3)
--               ->  Hash Join  (cost=1406.10..120823.77 rows=160763 width=4) (actual time=11.375..431.486 rows=129738 loops=3)
--                     Hash Cond: (tickets.session_id = sessions.id)
--                     ->  Parallel Seq Scan on tickets  (cost=0.00..115778.93 rows=1386127 width=8) (actual time=7.387..313.147 rows=1110762 loops=3)
--                           Filter: (status = 'book'::text)
--                           Rows Removed by Filter: 2222571
--                     ->  Hash  (cost=1261.12..1261.12 rows=11598 width=4) (actual time=3.887..3.888 rows=11654 loops=3)
--                           Buckets: 16384  Batches: 1  Memory Usage: 538kB
--                           ->  Bitmap Heap Scan on sessions  (cost=247.19..1261.12 rows=11598 width=4) (actual time=0.648..2.781 rows=11654 loops=3)
-- "                                Recheck Cond: ((datetime >= date_trunc('week'::text, (now())::timestamp without time zone)) AND (datetime <= (date_trunc('week'::text, (now())::timestamp without time zone) + '6 days 23:59:00'::interval)))"
--                                 Heap Blocks: exact=637
--                                 ->  Bitmap Index Scan on idx_datetime  (cost=0.00..244.29 rows=11598 width=0) (actual time=0.579..0.579 rows=11654 loops=3)
-- "                                      Index Cond: ((datetime >= date_trunc('week'::text, (now())::timestamp without time zone)) AND (datetime <= (date_trunc('week'::text, (now())::timestamp without time zone) + '6 days 23:59:00'::interval)))"
-- Planning Time: 0.161 ms
-- JIT:
--   Functions: 56
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.266 ms, Inlining 0.000 ms, Optimization 0.950 ms, Emission 21.248 ms, Total 24.464 ms"
-- Execution Time: 454.774 ms

create index ticket_book_status on tickets (status)
    where status = 'book';

-- Finalize Aggregate  (cost=116201.74..116201.75 rows=1 width=8) (actual time=385.561..389.948 rows=1 loops=1)
--   ->  Gather  (cost=116201.52..116201.73 rows=2 width=8) (actual time=385.165..389.933 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=115201.52..115201.53 rows=1 width=8) (actual time=372.358..372.360 rows=1 loops=3)
--               ->  Hash Join  (cost=30139.53..114799.62 rows=160761 width=4) (actual time=84.133..366.665 rows=129738 loops=3)
--                     Hash Cond: (tickets.session_id = sessions.id)
--                     ->  Parallel Bitmap Heap Scan on tickets  (cost=28733.43..109754.82 rows=1386111 width=8) (actual time=72.163..234.393 rows=1110762 loops=3)
--                           Recheck Cond: (status = 'book'::text)
--                           Heap Blocks: exact=22605
--                           ->  Bitmap Index Scan on ticket_book_status  (cost=0.00..27901.76 rows=3326667 width=0) (actual time=74.637..74.638 rows=3332287 loops=1)
--                     ->  Hash  (cost=1261.12..1261.12 rows=11598 width=4) (actual time=11.813..11.814 rows=11654 loops=3)
--                           Buckets: 16384  Batches: 1  Memory Usage: 538kB
--                           ->  Bitmap Heap Scan on sessions  (cost=247.19..1261.12 rows=11598 width=4) (actual time=8.345..10.631 rows=11654 loops=3)
-- "                                Recheck Cond: ((datetime >= date_trunc('week'::text, (now())::timestamp without time zone)) AND (datetime <= (date_trunc('week'::text, (now())::timestamp without time zone) + '6 days 23:59:00'::interval)))"
--                                 Heap Blocks: exact=637
--                                 ->  Bitmap Index Scan on idx_datetime  (cost=0.00..244.29 rows=11598 width=0) (actual time=8.273..8.273 rows=11654 loops=3)
-- "                                      Index Cond: ((datetime >= date_trunc('week'::text, (now())::timestamp without time zone)) AND (datetime <= (date_trunc('week'::text, (now())::timestamp without time zone) + '6 days 23:59:00'::interval)))"
-- Planning Time: 0.211 ms
-- JIT:
--   Functions: 56
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.487 ms, Inlining 0.000 ms, Optimization 0.909 ms, Emission 22.304 ms, Total 25.700 ms"
-- Execution Time: 390.723 ms


--Анализ: Создание индекса по полю status ускорило выполнение запроса примерно на 30%, но немного увеличилось время планирования запроса
--Вывод: Создание индекса оправдано