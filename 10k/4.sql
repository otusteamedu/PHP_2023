--Поиск 3 самых прибыльных фильмов за неделю
EXPLAIN ANALYSE
SELECT
    m.name,
    sum(t.price) AS total_price
FROM
    tickets AS t
        LEFT JOIN showtime AS s ON t.showtime_id = s.id
        LEFT JOIN movies AS m ON s.movie_id = m.id
WHERE
       (s.start_time BETWEEN (CURRENT_DATE - INTERVAL '7 day') AND CURRENT_DATE) AND t.price IS NOT NULL
GROUP BY
    m.name
ORDER BY
    total_price DESC
LIMIT 3;

-- Limit  (cost=290.84..290.84 rows=3 width=548) (actual time=2.589..2.591 rows=3 loops=1)
--   ->  Sort  (cost=290.84..290.94 rows=43 width=548) (actual time=2.588..2.590 rows=3 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=289.42..290.28 rows=43 width=548) (actual time=2.295..2.554 rows=8 loops=1)
--               Group Key: m.name
--               ->  Sort  (cost=289.42..289.53 rows=43 width=530) (actual time=2.258..2.317 rows=1424 loops=1)
--                     Sort Key: m.name
--                     Sort Method: quicksort  Memory: 158kB
--                     ->  Hash Join  (cost=100.79..288.25 rows=43 width=530) (actual time=0.099..1.794 rows=1424 loops=1)
--                           Hash Cond: (t.showtime_id = s.id)
--                           ->  Seq Scan on tickets t  (cost=0.00..153.60 rows=8915 width=18) (actual time=0.014..0.980 rows=10000 loops=1)
--                                 Filter: (price IS NOT NULL)
--                           ->  Hash  (cost=100.70..100.70 rows=7 width=520) (actual time=0.052..0.053 rows=15 loops=1)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                 ->  Nested Loop Left Join  (cost=0.28..100.70 rows=7 width=520) (actual time=0.021..0.045 rows=15 loops=1)
--                                       ->  Seq Scan on showtime s  (cost=0.00..42.62 rows=7 width=8) (actual time=0.005..0.016 rows=15 loops=1)
--                                             Filter: ((start_time <= CURRENT_DATE) AND (start_time >= (CURRENT_DATE - '7 days'::interval)))
--                                             Rows Removed by Filter: 85
--                                       ->  Index Scan using movies_pkey on movies m  (cost=0.28..8.29 rows=1 width=520) (actual time=0.002..0.002 rows=1 loops=15)
--                                             Index Cond: (id = s.movie_id)
-- Planning Time: 2.038 ms
-- Execution Time: 2.701 ms



create index idx_sessions_datetime on showtime(start_time);

-- Limit  (cost=270.85..270.86 rows=3 width=59) (actual time=6.711..6.723 rows=3 loops=1)
--   ->  Sort  (cost=270.85..274.85 rows=1600 width=59) (actual time=6.705..6.715 rows=3 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=230.17..250.17 rows=1600 width=59) (actual time=6.640..6.665 rows=8 loops=1)
--               Group Key: m.name
--               Batches: 1  Memory Usage: 73kB
--               ->  Hash Join  (cost=4.67..222.17 rows=1600 width=32) (actual time=0.230..5.992 rows=1424 loops=1)
--                     Hash Cond: (t.showtime_id = s.id)
--                     ->  Seq Scan on tickets t  (cost=0.00..164.00 rows=10000 width=9) (actual time=0.023..3.361 rows=10000 loops=1)
--                           Filter: (price IS NOT NULL)
--                     ->  Hash  (cost=4.47..4.47 rows=16 width=31) (actual time=0.151..0.156 rows=15 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                           ->  Merge Right Join  (cost=3.86..4.47 rows=16 width=31) (actual time=0.117..0.130 rows=15 loops=1)
--                                 Merge Cond: (m.id = s.movie_id)
--                                 ->  Index Scan using movies_pkey on movies m  (cost=0.29..354.29 rows=10000 width=31) (actual time=0.047..0.051 rows=11 loops=1)
--                                 ->  Sort  (cost=3.57..3.61 rows=16 width=8) (actual time=0.060..0.063 rows=15 loops=1)
--                                       Sort Key: s.movie_id
--                                       Sort Method: quicksort  Memory: 25kB
--                                       ->  Seq Scan on showtime s  (cost=0.00..3.25 rows=16 width=8) (actual time=0.008..0.028 rows=15 loops=1)
--                                             Filter: ((start_time <= CURRENT_DATE) AND (start_time >= (CURRENT_DATE - '7 days'::interval)))
--                                             Rows Removed by Filter: 85
-- Planning Time: 1.005 ms
-- Execution Time: 7.117 ms
