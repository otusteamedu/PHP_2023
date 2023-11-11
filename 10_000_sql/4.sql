EXPLAIN ANALYSE
SELECT
    f.name,
    sum(p.price) AS total_price
FROM
    tickets AS t
        LEFT JOIN sessions AS s ON t.session_id = s.id
        LEFT JOIN prices p ON s.id = p.session_id
        LEFT JOIN films f ON s.film_id = f.id
WHERE
        t.status = 'book' AND (s.datetime::date BETWEEN (CURRENT_DATE - INTERVAL '7 day') AND CURRENT_DATE)
GROUP BY
    f.name
ORDER BY
    total_price DESC
    LIMIT 3;


-- Limit  (cost=513.29..513.30 rows=3 width=35) (actual time=4.647..4.650 rows=3 loops=1)
--   ->  Sort  (cost=513.29..513.72 rows=170 width=35) (actual time=4.640..4.642 rows=3 loops=1)
--         Sort Key: (sum(p.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=509.40..511.10 rows=170 width=35) (actual time=4.598..4.623 rows=130 loops=1)
--               Group Key: f.name
--               Batches: 1  Memory Usage: 48kB
--               ->  Hash Join  (cost=265.36..508.55 rows=170 width=35) (actual time=1.325..3.832 rows=4450 loops=1)
--                     Hash Cond: (s.id = t.session_id)
--                     ->  Nested Loop Left Join  (cost=34.86..274.83 rows=50 width=39) (actual time=0.157..2.147 rows=1362 loops=1)
--                           ->  Hash Right Join  (cost=34.56..224.60 rows=50 width=16) (actual time=0.149..1.445 rows=1362 loops=1)
--                                 Hash Cond: (p.session_id = s.id)
--                                 ->  Seq Scan on prices p  (cost=0.00..163.74 rows=9974 width=12) (actual time=0.002..0.451 rows=9974 loops=1)
--                                 ->  Hash  (cost=34.50..34.50 rows=5 width=8) (actual time=0.142..0.143 rows=139 loops=1)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 14kB
--                                       ->  Seq Scan on sessions s  (cost=0.00..34.50 rows=5 width=8) (actual time=0.008..0.121 rows=139 loops=1)
--                                             Filter: (((datetime)::date <= CURRENT_DATE) AND ((datetime)::date >= (CURRENT_DATE - '7 days'::interval)))
--                                             Rows Removed by Filter: 861
--                           ->  Memoize  (cost=0.30..8.31 rows=1 width=31) (actual time=0.000..0.000 rows=1 loops=1362)
--                                 Cache Key: s.film_id
--                                 Cache Mode: logical
--                                 Hits: 1227  Misses: 135  Evictions: 0  Overflows: 0  Memory Usage: 18kB
--                                 ->  Index Scan using films_pk on films f  (cost=0.29..8.30 rows=1 width=31) (actual time=0.002..0.002 rows=1 loops=135)
--                                       Index Cond: (id = s.film_id)
--                     ->  Hash  (cost=189.00..189.00 rows=3320 width=4) (actual time=1.162..1.162 rows=3320 loops=1)
--                           Buckets: 4096  Batches: 1  Memory Usage: 149kB
--                           ->  Seq Scan on tickets t  (cost=0.00..189.00 rows=3320 width=4) (actual time=0.003..0.896 rows=3320 loops=1)
--                                 Filter: (status = 'book'::text)
--                                 Rows Removed by Filter: 6680
-- Planning Time: 0.362 ms
-- Execution Time: 4.719 ms

CREATE INDEX idx_session_datetime ON sessions((datetime::date));

-- Limit  (cost=490.07..490.08 rows=3 width=35) (actual time=4.470..4.474 rows=3 loops=1)
--   ->  Sort  (cost=490.07..490.50 rows=170 width=35) (actual time=4.469..4.472 rows=3 loops=1)
--         Sort Key: (sum(p.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=486.17..487.87 rows=170 width=35) (actual time=4.438..4.454 rows=130 loops=1)
--               Group Key: f.name
--               Batches: 1  Memory Usage: 48kB
--               ->  Hash Join  (cost=242.13..485.32 rows=170 width=35) (actual time=1.228..3.678 rows=4450 loops=1)
--                     Hash Cond: (s.id = t.session_id)
--                     ->  Nested Loop Left Join  (cost=11.63..251.60 rows=50 width=39) (actual time=0.067..1.988 rows=1362 loops=1)
--                           ->  Hash Right Join  (cost=11.34..201.37 rows=50 width=16) (actual time=0.060..1.341 rows=1362 loops=1)
--                                 Hash Cond: (p.session_id = s.id)
--                                 ->  Seq Scan on prices p  (cost=0.00..163.74 rows=9974 width=12) (actual time=0.003..0.448 rows=9974 loops=1)
--                                 ->  Hash  (cost=11.28..11.28 rows=5 width=8) (actual time=0.053..0.054 rows=139 loops=1)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 14kB
--                                       ->  Bitmap Heap Scan on sessions s  (cost=4.21..11.28 rows=5 width=8) (actual time=0.013..0.039 rows=139 loops=1)
--                                             Recheck Cond: (((datetime)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((datetime)::date <= CURRENT_DATE))
--                                             Heap Blocks: exact=7
--                                             ->  Bitmap Index Scan on idx_session_datetime  (cost=0.00..4.21 rows=5 width=0) (actual time=0.009..0.009 rows=139 loops=1)
--                                                   Index Cond: (((datetime)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((datetime)::date <= CURRENT_DATE))
--                           ->  Memoize  (cost=0.30..8.31 rows=1 width=31) (actual time=0.000..0.000 rows=1 loops=1362)
--                                 Cache Key: s.film_id
--                                 Cache Mode: logical
--                                 Hits: 1227  Misses: 135  Evictions: 0  Overflows: 0  Memory Usage: 18kB
--                                 ->  Index Scan using films_pk on films f  (cost=0.29..8.30 rows=1 width=31) (actual time=0.001..0.001 rows=1 loops=135)
--                                       Index Cond: (id = s.film_id)
--                     ->  Hash  (cost=189.00..189.00 rows=3320 width=4) (actual time=1.156..1.156 rows=3320 loops=1)
--                           Buckets: 4096  Batches: 1  Memory Usage: 149kB
--                           ->  Seq Scan on tickets t  (cost=0.00..189.00 rows=3320 width=4) (actual time=0.003..0.874 rows=3320 loops=1)
--                                 Filter: (status = 'book'::text)
--                                 Rows Removed by Filter: 6680
-- Planning Time: 0.317 ms
-- Execution Time: 4.540 ms

-- Анализ показал, что планировщик учел созданный индекс при построении запроса, однако время выполнения запроса практически не изменилось.
-- Вывод: Время выполнения запроса с индексом по полю datetime практически не изменилось. Добавление индекса не оправдано.
