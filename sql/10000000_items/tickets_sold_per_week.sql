explain analyse SELECT COUNT(*) AS ticket_count
FROM tickets
     JOIN session_place_price ON tickets.session_place_price_id = session_place_price.id
     JOIN sessions ON session_place_price.session_id = sessions.id
WHERE sessions.date_start >= CURRENT_DATE - INTERVAL '7 days';

-- Резульат:
-- Aggregate  (cost=3048.25..3048.26 rows=1 width=8) (actual time=224.764..224.785 rows=1 loops=1)
--   ->  Hash Join  (cost=803.25..3043.44 rows=1926 width=0) (actual time=50.751..222.211 rows=2133 loops=1)
--         Hash Cond: (session_place_price.session_id = sessions.id)
--         ->  Merge Join  (cost=366.44..2594.52 rows=4612 width=4) (actual time=15.556..182.952 rows=4612 loops=1)
--               Merge Cond: (session_place_price.id = tickets.session_place_price_id)
--               ->  Index Scan using session_place_price_pkey on session_place_price  (cost=0.43..282367.84 rows=8999960 width=8) (actual time=0.026..78.660 rows=59990 loops=1)
--               ->  Sort  (cost=365.79..377.32 rows=4612 width=4) (actual time=15.507..21.098 rows=4612 loops=1)
--                     Sort Key: tickets.session_place_price_id
--                     Sort Method: quicksort  Memory: 193kB
--                     ->  Seq Scan on tickets  (cost=0.00..85.12 rows=4612 width=4) (actual time=0.014..7.741 rows=4612 loops=1)
--         ->  Hash  (cost=358.50..358.50 rows=6265 width=4) (actual time=30.851..30.855 rows=6258 loops=1)
--               Buckets: 8192  Batches: 1  Memory Usage: 285kB
--               ->  Seq Scan on sessions  (cost=0.00..358.50 rows=6265 width=4) (actual time=0.017..18.173 rows=6258 loops=1)
--                     Filter: (date_start >= (CURRENT_DATE - '7 days'::interval))
--                     Rows Removed by Filter: 8742
-- Planning Time: 0.735 ms
-- Execution Time: 224.849 ms




-- Индекс на столбец session_place_price_id в таблице tickets.
CREATE INDEX idx_sold_date_film_id ON tickets (sold_date, film_id);
-- Индекс на столбец session_id в таблице session_place_price.
CREATE INDEX idx_session_id ON session_place_price (session_id);
-- Индекс на столбец date_start в таблице sessions.
CREATE INDEX idx_date_start ON sessions (date_start);

explain analyse SELECT COUNT(*) AS ticket_count
FROM tickets
         JOIN session_place_price ON tickets.session_place_price_id = session_place_price.id
         JOIN sessions ON session_place_price.session_id = sessions.id
WHERE sessions.date_start >= CURRENT_DATE - INTERVAL '7 days';

-- Результат после приминения индексов:
-- Aggregate  (cost=2736.37..2736.38 rows=1 width=8) (actual time=213.974..213.996 rows=1 loops=1)
--   ->  Hash Join  (cost=374.82..2731.56 rows=1926 width=0) (actual time=33.315..211.397 rows=2133 loops=1)
--         Hash Cond: (session_place_price.session_id = sessions.id)
--         ->  Merge Join  (cost=2.03..2346.66 rows=4612 width=4) (actual time=0.086..174.708 rows=4612 loops=1)
--               Merge Cond: (tickets.session_place_price_id = session_place_price.id)
--               ->  Index Only Scan using idx_session_place_price_id on tickets  (cost=0.28..129.46 rows=4612 width=4) (actual time=0.037..6.339 rows=4612 loops=1)
--                     Heap Fetches: 0
--               ->  Index Scan using session_place_price_pkey on session_place_price  (cost=0.43..282368.43 rows=9000000 width=8) (actual time=0.022..82.118 rows=59989 loops=1)
--         ->  Hash  (cost=294.48..294.48 rows=6265 width=4) (actual time=28.008..28.016 rows=6258 loops=1)
--               Buckets: 8192  Batches: 1  Memory Usage: 285kB
--               ->  Bitmap Heap Scan on sessions  (cost=88.84..294.48 rows=6265 width=4) (actual time=0.807..14.501 rows=6258 loops=1)
--                     Recheck Cond: (date_start >= (CURRENT_DATE - '7 days'::interval))
--                     Heap Blocks: exact=96
--                     ->  Bitmap Index Scan on idx_date_start  (cost=0.00..87.28 rows=6265 width=0) (actual time=0.749..0.750 rows=6258 loops=1)
--                           Index Cond: (date_start >= (CURRENT_DATE - '7 days'::interval))
-- Planning Time: 1.803 ms
-- Execution Time: 214.109 ms


-- Вывод: Индексы не повлияли на производительность запроса.
