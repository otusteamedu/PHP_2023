explain analyse SELECT COUNT(*) AS ticket_count
FROM tickets
     JOIN session_place_price ON tickets.session_place_price_id = session_place_price.id
     JOIN sessions ON session_place_price.session_id = sessions.id
WHERE sessions.date_start >= CURRENT_DATE - INTERVAL '7 days';

-- Резульат:
-- Aggregate  (cost=3053.53..3053.54 rows=1 width=8) (actual time=210.327..210.348 rows=1 loops=1)
--   ->  Hash Join  (cost=718.91..3047.98 rows=2220 width=0) (actual time=29.409..207.983 rows=1959 loops=1)
--         Hash Cond: (session_place_price.session_id = sessions.id)
--         ->  Merge Join  (cost=427.71..2742.81 rows=5315 width=4) (actual time=15.156..184.653 rows=5315 loops=1)
--               Merge Cond: (session_place_price.id = tickets.session_place_price_id)
--               ->  Index Scan using session_place_price_pkey on session_place_price  (cost=0.43..188254.01 rows=6000105 width=8) (actual time=0.017..78.603 rows=59987 loops=1)
--               ->  Sort  (cost=427.04..440.33 rows=5315 width=4) (actual time=15.022..21.438 rows=5315 loops=1)
--                     Sort Key: tickets.session_place_price_id
--                     Sort Method: quicksort  Memory: 193kB
--                     ->  Seq Scan on tickets  (cost=0.00..98.15 rows=5315 width=4) (actual time=0.010..7.471 rows=5315 loops=1)
--         ->  Hash  (cost=239.00..239.00 rows=4176 width=4) (actual time=14.231..14.236 rows=4175 loops=1)
--               Buckets: 8192  Batches: 1  Memory Usage: 211kB
--               ->  Seq Scan on sessions  (cost=0.00..239.00 rows=4176 width=4) (actual time=0.026..7.999 rows=4175 loops=1)
--                     Filter: (date_start >= (CURRENT_DATE - '7 days'::interval))
--                     Rows Removed by Filter: 5825
-- Planning Time: 0.579 ms
-- Execution Time: 210.396 ms



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
-- Aggregate  (cost=3016.25..3016.26 rows=1 width=8) (actual time=224.546..224.571 rows=1 loops=1)
--   ->  Hash Join  (cost=681.64..3010.70 rows=2220 width=0) (actual time=39.063..222.107 rows=1959 loops=1)
--         Hash Cond: (session_place_price.session_id = sessions.id)
--         ->  Merge Join  (cost=427.71..2742.80 rows=5315 width=4) (actual time=21.118..194.858 rows=5315 loops=1)
--               Merge Cond: (session_place_price.id = tickets.session_place_price_id)
--               ->  Index Scan using session_place_price_pkey on session_place_price  (cost=0.43..188252.43 rows=6000000 width=8) (actual time=0.027..80.631 rows=59987 loops=1)
--               ->  Sort  (cost=427.04..440.33 rows=5315 width=4) (actual time=20.958..27.475 rows=5315 loops=1)
--                     Sort Key: tickets.session_place_price_id
--                     Sort Method: quicksort  Memory: 193kB
--                     ->  Seq Scan on tickets  (cost=0.00..98.15 rows=5315 width=4) (actual time=0.017..10.546 rows=5315 loops=1)
--         ->  Hash  (cost=201.73..201.73 rows=4176 width=4) (actual time=17.897..17.904 rows=4175 loops=1)
--               Buckets: 8192  Batches: 1  Memory Usage: 211kB
--               ->  Bitmap Heap Scan on sessions  (cost=64.65..201.73 rows=4176 width=4) (actual time=0.527..9.232 rows=4175 loops=1)
--                     Recheck Cond: (date_start >= (CURRENT_DATE - '7 days'::interval))
--                     Heap Blocks: exact=64
--                     ->  Bitmap Index Scan on idx_date_start  (cost=0.00..63.61 rows=4176 width=0) (actual time=0.485..0.487 rows=4175 loops=1)
--                           Index Cond: (date_start >= (CURRENT_DATE - '7 days'::interval))
-- Planning Time: 1.206 ms
-- Execution Time: 224.674 ms

-- Вывод: Индексы повлияли на производительность запроса негативно.
