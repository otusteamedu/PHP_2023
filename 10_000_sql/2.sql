EXPLAIN ANALYSE
SELECT
    count(tickets.id)
FROM
    tickets
    LEFT JOIN sessions ON tickets.session_id = sessions.id
WHERE
    sessions.datetime BETWEEN date_trunc('week', now()::timestamp)::timestamp
    AND (date_trunc('week', now()::timestamp) + '6 days 23 hours 59 minutes'::interval)::timestamp
    AND tickets.status = 'book';

-- Aggregate  (cost=240.21..240.22 rows=1 width=8) (actual time=21.756..21.780 rows=1 loops=1)
--   ->  Hash Join  (cost=41.23..239.05 rows=462 width=4) (actual time=1.995..20.767 rows=442 loops=1)
--         Hash Cond: (tickets.session_id = sessions.id)
--         ->  Seq Scan on tickets  (cost=0.00..189.00 rows=3351 width=8) (actual time=0.018..10.214 rows=3351 loops=1)
--               Filter: (status = 'book'::text)
--               Rows Removed by Filter: 6649
--         ->  Hash  (cost=39.50..39.50 rows=138 width=4) (actual time=1.924..1.931 rows=136 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 13kB
--               ->  Seq Scan on sessions  (cost=0.00..39.50 rows=138 width=4) (actual time=0.013..1.609 rows=136 loops=1)
-- "                    Filter: ((datetime >= date_trunc('week'::text, (now())::timestamp without time zone)) AND (datetime <= (date_trunc('week'::text, (now())::timestamp without time zone) + '6 days 23:59:00'::interval)))"
--                     Rows Removed by Filter: 864
-- Planning Time: 0.467 ms
-- Execution Time: 21.848 ms

create index ticket_book_status on tickets (status)
    where status = 'book';

-- Aggregate  (cost=194.97..194.98 rows=1 width=8) (actual time=20.595..20.624 rows=1 loops=1)
--   ->  Hash Join  (cost=79.10..193.81 rows=462 width=4) (actual time=2.516..19.609 rows=442 loops=1)
--         Hash Cond: (tickets.session_id = sessions.id)
--         ->  Bitmap Heap Scan on tickets  (cost=37.87..143.76 rows=3351 width=8) (actual time=0.250..8.385 rows=3351 loops=1)
--               Recheck Cond: (status = 'book'::text)
--               Heap Blocks: exact=64
--               ->  Bitmap Index Scan on ticket_book_status  (cost=0.00..37.03 rows=3351 width=0) (actual time=0.207..0.210 rows=3351 loops=1)
--         ->  Hash  (cost=39.50..39.50 rows=138 width=4) (actual time=2.207..2.215 rows=136 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 13kB
--               ->  Seq Scan on sessions  (cost=0.00..39.50 rows=138 width=4) (actual time=0.020..1.863 rows=136 loops=1)
-- "                    Filter: ((datetime >= date_trunc('week'::text, (now())::timestamp without time zone)) AND (datetime <= (date_trunc('week'::text, (now())::timestamp without time zone) + '6 days 23:59:00'::interval)))"
--                     Rows Removed by Filter: 864
-- Planning Time: 0.536 ms
-- Execution Time: 20.712 ms

-- Анализ показал, что планировщик учел созданный индекс при построении запроса. Время выполнения запроса немного уменьшилось, однако индекс занял часть оперативной памяти
-- Вывод: Время выполнения запроса с частичным индексом по полю status уменьшилось незначительно. Добавление индекса не оправдано.