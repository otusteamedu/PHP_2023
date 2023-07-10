explain analyse SELECT COUNT(tickets.id) AS ticket_count
FROM tickets
     JOIN session_place_price ON tickets.session_place_price_id = session_place_price.id
     JOIN sessions ON session_place_price.session_id = sessions.id
WHERE sessions.date_start >= CURRENT_DATE - INTERVAL '7 days';

-- Резульат:
-- Aggregate  (cost=11450.15..11450.16 rows=1 width=8) (actual time=30.403..30.424 rows=1 loops=1)
--   ->  Hash Join  (cost=282.13..11449.02 rows=452 width=4) (actual time=13.718..29.519 rows=684 loops=1)
--         Hash Cond: (session_place_price.session_id = sessions.id)
--         ->  Nested Loop  (cost=0.43..11163.76 rows=1356 width=8) (actual time=0.039..13.015 rows=1406 loops=1)
--               ->  Seq Scan on tickets  (cost=0.00..25.56 rows=1356 width=8) (actual time=0.018..1.933 rows=1406 loops=1)
--               ->  Index Scan using session_place_price_pkey on session_place_price  (cost=0.43..8.21 rows=1 width=8) (actual time=0.004..0.004 rows=1 loops=1406)
--                     Index Cond: (id = tickets.session_place_price_id)
--         ->  Hash  (cost=239.84..239.84 rows=3349 width=4) (actual time=13.664..13.669 rows=4104 loops=1)
--               Buckets: 8192 (originally 4096)  Batches: 1 (originally 1)  Memory Usage: 209kB
--               ->  Seq Scan on sessions  (cost=0.00..239.84 rows=3349 width=4) (actual time=0.033..7.664 rows=4104 loops=1)
--                     Filter: (date_start >= (CURRENT_DATE - '7 days'::interval))
--                     Rows Removed by Filter: 5896
-- Planning Time: 0.380 ms
-- Execution Time: 30.484 ms

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
-- Aggregate  (cost=2363.08..2363.09 rows=1 width=8) (actual time=191.246..191.268 rows=1 loops=1)
--   ->  Hash Join  (cost=249.42..2361.64 rows=577 width=4) (actual time=17.535..190.373 rows=684 loops=1)
--         Hash Cond: (session_place_price.session_id = sessions.id)
--         ->  Merge Join  (cost=2.20..2110.73 rows=1406 width=8) (actual time=0.241..170.255 rows=1406 loops=1)
--               Merge Cond: (tickets.session_place_price_id = session_place_price.id)
--               ->  Index Scan using idx_session_place_price_id on tickets  (cost=0.28..93.37 rows=1406 width=8) (actual time=0.019..2.676 rows=1406 loops=1)
--               ->  Index Scan using session_place_price_pkey on session_place_price  (cost=0.43..188252.30 rows=5999991 width=8) (actual time=0.018..85.699 rows=59971 loops=1)
--         ->  Hash  (cost=195.92..195.92 rows=4104 width=4) (actual time=17.270..17.278 rows=4104 loops=1)
--               Buckets: 8192  Batches: 1  Memory Usage: 209kB
--               ->  Bitmap Heap Scan on sessions  (cost=60.10..195.92 rows=4104 width=4) (actual time=0.432..8.874 rows=4104 loops=1)
--                     Recheck Cond: (date_start >= (CURRENT_DATE - '7 days'::interval))
--                     Heap Blocks: exact=64
--                     ->  Bitmap Index Scan on idx_date_start  (cost=0.00..59.07 rows=4104 width=0) (actual time=0.388..0.390 rows=4104 loops=1)
--                           Index Cond: (date_start >= (CURRENT_DATE - '7 days'::interval))
-- Planning Time: 1.472 ms
-- Execution Time: 191.351 ms


-- Вывод: Индексы повлияли на производительность запроса негативно.
