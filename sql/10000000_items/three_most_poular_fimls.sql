explain analyse SELECT film.name AS film_name, SUM(ticket.final_price) AS total_profit
FROM films film
         INNER JOIN tickets ticket ON film.id = ticket.film_id
WHERE ticket.sold_date >= CURRENT_DATE - INTERVAL '7 days'
GROUP BY film.name
ORDER BY total_profit DESC
    LIMIT 3;

-- Результат
-- Limit  (cost=151.22..151.22 rows=3 width=43) (actual time=7.200..7.239 rows=3 loops=1)
--   ->  Sort  (cost=151.22..151.30 rows=33 width=43) (actual time=7.194..7.220 rows=3 loops=1)
--         Sort Key: (sum(ticket.final_price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=150.13..150.79 rows=33 width=43) (actual time=6.906..7.125 rows=28 loops=1)
--               Group Key: film.name
--               ->  Sort  (cost=150.13..150.21 rows=33 width=16) (actual time=6.884..6.954 rows=31 loops=1)
--                     Sort Key: film.name
--                     Sort Method: quicksort  Memory: 26kB
--                     ->  Hash Join  (cost=29.50..149.30 rows=33 width=16) (actual time=4.361..6.756 rows=31 loops=1)
--                           Hash Cond: (ticket.film_id = film.id)
--                           ->  Seq Scan on tickets ticket  (cost=0.00..119.71 rows=33 width=9) (actual time=0.089..2.352 rows=31 loops=1)
--                                 Filter: (sold_date >= (CURRENT_DATE - '7 days'::interval))
--                                 Rows Removed by Filter: 4581
--                           ->  Hash  (cost=17.00..17.00 rows=1000 width=15) (actual time=4.256..4.261 rows=1000 loops=1)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 55kB
--                                 ->  Seq Scan on films film  (cost=0.00..17.00 rows=1000 width=15) (actual time=0.012..2.091 rows=1000 loops=1)
-- Planning Time: 0.750 ms
-- Execution Time: 7.320 ms


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
-- Limit  (cost=75.23..75.24 rows=3 width=43) (actual time=2.930..2.955 rows=3 loops=1)
--   ->  Sort  (cost=75.23..75.31 rows=33 width=43) (actual time=2.926..2.944 rows=3 loops=1)
--         Sort Key: (sum(ticket.final_price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=74.39..74.80 rows=33 width=43) (actual time=2.835..2.889 rows=28 loops=1)
--               Group Key: film.name
--               Batches: 1  Memory Usage: 32kB
--               ->  Hash Join  (cost=34.04..74.23 rows=33 width=16) (actual time=2.598..2.767 rows=31 loops=1)
--                     Hash Cond: (ticket.film_id = film.id)
--                     ->  Bitmap Heap Scan on tickets ticket  (cost=4.54..44.64 rows=33 width=9) (actual time=0.017..0.100 rows=31 loops=1)
--                           Recheck Cond: (sold_date >= (CURRENT_DATE - '7 days'::interval))
--                           Heap Blocks: exact=22
--                           ->  Bitmap Index Scan on idx_sold_date_film_id  (cost=0.00..4.53 rows=33 width=0) (actual time=0.009..0.011 rows=31 loops=1)
--                                 Index Cond: (sold_date >= (CURRENT_DATE - '7 days'::interval))
--                     ->  Hash  (cost=17.00..17.00 rows=1000 width=15) (actual time=2.572..2.576 rows=1000 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 55kB
--                           ->  Seq Scan on films film  (cost=0.00..17.00 rows=1000 width=15) (actual time=0.006..1.264 rows=1000 loops=1)
-- Planning Time: 0.250 ms
-- Execution Time: 2.995 ms

-- Вывод: Индексы значительно повлияли на производительность запроса