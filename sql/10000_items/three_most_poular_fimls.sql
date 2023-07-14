explain analyse SELECT film.name AS film_name, SUM(ticket.final_price) AS total_profit
FROM films film
         INNER JOIN tickets ticket ON film.id = ticket.film_id
WHERE ticket.sold_date >= CURRENT_DATE - INTERVAL '7 days'
GROUP BY film.name
ORDER BY total_profit DESC
    LIMIT 3;

-- Результат
-- Limit  (cost=278.62..278.63 rows=3 width=548) (actual time=26.243..26.268 rows=3 loops=1)
--   ->  Sort  (cost=278.62..279.12 rows=200 width=548) (actual time=26.239..26.255 rows=3 loops=1)
--         Sort Key: (sum(ticket.final_price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=273.54..276.04 rows=200 width=548) (actual time=26.085..26.176 rows=47 loops=1)
--               Group Key: film.name
--               Batches: 1  Memory Usage: 64kB
--               ->  Hash Join  (cost=84.16..262.61 rows=2185 width=532) (actual time=24.799..26.000 rows=48 loops=1)
--                     Hash Cond: (ticket.film_id = film.id)
--                     ->  Seq Scan on tickets ticket  (cost=0.00..172.69 rows=2185 width=20) (actual time=0.045..1.117 rows=48 loops=1)
--                           Filter: (sold_date >= (CURRENT_DATE - '7 days'::interval))
--                           Rows Removed by Filter: 6815
--                     ->  Hash  (cost=72.96..72.96 rows=896 width=520) (actual time=24.742..24.746 rows=10000 loops=1)
--                           Buckets: 16384 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 597kB
--                           ->  Seq Scan on films film  (cost=0.00..72.96 rows=896 width=520) (actual time=0.008..12.250 rows=10000 loops=1)
-- Planning Time: 0.230 ms
-- Execution Time: 26.319 ms

-- Индекс на столбецы sold_date, film_id таблицы tickets:
CREATE INDEX idx_sold_date_film_id ON tickets (sold_date, film_id);

explain analyse SELECT film.name AS film_name, SUM(ticket.final_price) AS total_profit
FROM films film
         INNER JOIN tickets ticket ON film.id = ticket.film_id
WHERE ticket.sold_date >= CURRENT_DATE - INTERVAL '7 days'
GROUP BY film.name
ORDER BY total_profit DESC
LIMIT 3;

-- Результат после приминения индексов:
-- Limit  (cost=328.45..328.46 rows=3 width=43) (actual time=1.478..1.517 rows=3 loops=1)
--   ->  Sort  (cost=328.45..328.57 rows=47 width=43) (actual time=1.473..1.500 rows=3 loops=1)
--         Sort Key: (sum(ticket.final_price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=326.90..327.84 rows=47 width=43) (actual time=1.032..1.370 rows=47 loops=1)
--               Group Key: film.name
--               ->  Sort  (cost=326.90..327.02 rows=47 width=16) (actual time=1.011..1.112 rows=48 loops=1)
--                     Sort Key: film.name
--                     Sort Method: quicksort  Memory: 27kB
--                     ->  Nested Loop  (cost=4.94..325.60 rows=47 width=16) (actual time=0.064..0.859 rows=48 loops=1)
--                           ->  Bitmap Heap Scan on tickets ticket  (cost=4.65..63.38 rows=47 width=9) (actual time=0.043..0.220 rows=48 loops=1)
--                                 Recheck Cond: (sold_date >= (CURRENT_DATE - '7 days'::interval))
--                                 Heap Blocks: exact=35
--                                 ->  Bitmap Index Scan on idx_sold_date_film_id  (cost=0.00..4.64 rows=47 width=0) (actual time=0.022..0.025 rows=48 loops=1)
--                                       Index Cond: (sold_date >= (CURRENT_DATE - '7 days'::interval))
--                           ->  Index Scan using films_pkey on films film  (cost=0.29..5.58 rows=1 width=15) (actual time=0.007..0.007 rows=1 loops=48)
--                                 Index Cond: (id = ticket.film_id)
-- Planning Time: 0.463 ms
-- Execution Time: 1.594 ms

-- Вывод: Индексы значительно повлияли на производительность запроса