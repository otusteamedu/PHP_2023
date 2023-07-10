explain analyse SELECT COUNT(tickets.id) AS ticket_count
FROM tickets
     JOIN session_place_price ON tickets.session_place_price_id = session_place_price.id
     JOIN sessions ON session_place_price.session_id = sessions.id
WHERE sessions.date_start >= CURRENT_DATE - INTERVAL '7 days';

-- Резульат:
-- Aggregate  (cost=61487.95..61487.96 rows=1 width=8) (actual time=128.709..128.728 rows=1 loops=1)
--   ->  Hash Join  (cost=423.00..61481.27 rows=2674 width=4) (actual time=26.908..123.361 rows=4017 loops=1)
--         Hash Cond: (session_place_price.session_id = sessions.id)
--         ->  Nested Loop  (cost=0.43..61037.64 rows=8023 width=8) (actual time=0.059..79.072 rows=8508 loops=1)
--               ->  Seq Scan on tickets  (cost=0.00..151.23 rows=8023 width=8) (actual time=0.027..11.887 rows=8508 loops=1)
--               ->  Index Scan using session_place_price_pkey on session_place_price  (cost=0.43..7.59 rows=1 width=8) (actual time=0.004..0.004 rows=1 loops=8508)
--                     Index Cond: (id = tickets.session_place_price_id)
--         ->  Hash  (cost=359.76..359.76 rows=5024 width=4) (actual time=26.780..26.784 rows=6268 loops=1)
--               Buckets: 8192  Batches: 1  Memory Usage: 285kB
--               ->  Seq Scan on sessions  (cost=0.00..359.76 rows=5024 width=4) (actual time=0.037..15.621 rows=6268 loops=1)
--                     Filter: (date_start >= (CURRENT_DATE - '7 days'::interval))
--                     Rows Removed by Filter: 8732
-- Planning Time: 1.887 ms
-- Execution Time: 128.805 ms

-- Индекс на столбец session_place_price_id в таблице tickets.
CREATE INDEX idx_session_place_price_id ON tickets (session_place_price_id);
-- Индекс на столбец session_id в таблице session_place_price.
CREATE INDEX idx_session_id ON session_place_price (session_id);
-- Индекс на столбец date_start в таблице sessions.
CREATE INDEX idx_date_start ON sessions (date_start);

explain analyse SELECT COUNT(tickets.id) AS ticket_count
FROM tickets
     JOIN session_place_price ON tickets.session_place_price_id = session_place_price.id
     JOIN sessions ON session_place_price.session_id = sessions.id
WHERE sessions.date_start >= CURRENT_DATE - INTERVAL '7 days';

-- Результат после приминения индексов:
-- Aggregate  (cost=60636.83..60636.84 rows=1 width=8) (actual time=151.544..151.571 rows=1 loops=1)
--   ->  Hash Join  (cost=373.62..60627.94 rows=3559 width=4) (actual time=25.435..146.236 rows=4017 loops=1)
--         Hash Cond: (session_place_price.session_id = sessions.id)
--         ->  Nested Loop  (cost=0.45..60232.42 rows=8508 width=8) (actual time=0.047..103.652 rows=8508 loops=1)
--               ->  Seq Scan on tickets  (cost=0.00..156.08 rows=8508 width=8) (actual time=0.009..11.393 rows=8508 loops=1)
--               ->  Memoize  (cost=0.45..7.55 rows=1 width=8) (actual time=0.007..0.007 rows=1 loops=8508)
--                     Cache Key: tickets.session_place_price_id
--                     Cache Mode: logical
--                     Hits: 572  Misses: 7936  Evictions: 0  Overflows: 0  Memory Usage: 837kB
--                     ->  Index Scan using session_place_price_pkey on session_place_price  (cost=0.43..7.54 rows=1 width=8) (actual time=0.004..0.004 rows=1 loops=7936)
--                           Index Cond: (id = tickets.session_place_price_id)
--         ->  Hash  (cost=294.73..294.73 rows=6275 width=4) (actual time=25.310..25.319 rows=6268 loops=1)
--               Buckets: 8192  Batches: 1  Memory Usage: 285kB
--               ->  Bitmap Heap Scan on sessions  (cost=88.92..294.73 rows=6275 width=4) (actual time=0.539..13.009 rows=6268 loops=1)
--                     Recheck Cond: (date_start >= (CURRENT_DATE - '7 days'::interval))
--                     Heap Blocks: exact=96
--                     ->  Bitmap Index Scan on idx_date_start  (cost=0.00..87.35 rows=6275 width=0) (actual time=0.501..0.503 rows=6268 loops=1)
--                           Index Cond: (date_start >= (CURRENT_DATE - '7 days'::interval))
-- Planning Time: 1.056 ms
-- Execution Time: 151.705 ms

-- Вывод: Индексы повлияли на производительность запроса негативно.
