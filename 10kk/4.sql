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

-- Limit  (cost=32499.59..32499.60 rows=3 width=59) (actual time=94.647..94.714 rows=3 loops=1)
--   ->  Sort  (cost=32499.59..32737.46 rows=95147 width=59) (actual time=94.645..94.712 rows=3 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=17341.78..31269.84 rows=95147 width=59) (actual time=89.959..94.665 rows=10 loops=1)
--               Group Key: m.name
--               ->  Gather Merge  (cost=17341.78..29361.74 rows=95834 width=59) (actual time=89.323..94.647 rows=30 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=16341.76..17300.10 rows=47917 width=59) (actual time=79.995..84.775 rows=10 loops=3)
--                           Group Key: m.name
--                           ->  Sort  (cost=16341.76..16461.55 rows=47917 width=32) (actual time=79.247..80.562 rows=38019 loops=3)
--                                 Sort Key: m.name
--                                 Sort Method: quicksort  Memory: 3753kB
--                                 Worker 0:  Sort Method: quicksort  Memory: 3489kB
--                                 Worker 1:  Sort Method: quicksort  Memory: 3432kB
--                                 ->  Hash Join  (cost=38.29..12616.63 rows=47917 width=32) (actual time=0.372..68.807 rows=38019 loops=3)
--                                       Hash Cond: (t.showtime_id = s.id)
--                                       ->  Parallel Seq Scan on tickets t  (cost=0.00..10536.67 rows=416667 width=9) (actual time=0.015..47.396 rows=333333 loops=3)
--                                             Filter: (price IS NOT NULL)
--                                       ->  Hash  (cost=36.86..36.86 rows=115 width=31) (actual time=0.310..0.312 rows=114 loops=3)
--                                             Buckets: 1024  Batches: 1  Memory Usage: 15kB
--                                             ->  Merge Right Join  (cost=34.73..36.86 rows=115 width=31) (actual time=0.265..0.283 rows=114 loops=3)
--                                                   Merge Cond: (m.id = s.movie_id)
--                                                   ->  Index Scan using movies_pkey on movies m  (cost=0.29..3410.29 rows=100000 width=31) (actual time=0.020..0.022 rows=11 loops=3)
--                                                   ->  Sort  (cost=34.44..34.72 rows=115 width=8) (actual time=0.243..0.248 rows=114 loops=3)
--                                                         Sort Key: s.movie_id
--                                                         Sort Method: quicksort  Memory: 30kB
--                                                         Worker 0:  Sort Method: quicksort  Memory: 30kB
--                                                         Worker 1:  Sort Method: quicksort  Memory: 30kB
--                                                         ->  Seq Scan on showtime s  (cost=0.00..30.50 rows=115 width=8) (actual time=0.071..0.186 rows=114 loops=3)
--                                                               Filter: ((start_time <= CURRENT_DATE) AND (start_time >= (CURRENT_DATE - '7 days'::interval)))
--                                                               Rows Removed by Filter: 886
-- Planning Time: 6.557 ms
-- Execution Time: 95.180 ms

create index idx_sessions_datetime on showtime(start_time);

-- Limit  (cost=32485.14..32485.15 rows=3 width=59) (actual time=104.082..104.194 rows=3 loops=1)
--   ->  Sort  (cost=32485.14..32723.01 rows=95147 width=59) (actual time=104.080..104.192 rows=3 loops=1)
--         Sort Key: (sum(t.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=17327.33..31255.39 rows=95147 width=59) (actual time=98.889..104.153 rows=10 loops=1)
--               Group Key: m.name
--               ->  Gather Merge  (cost=17327.33..29347.29 rows=95834 width=59) (actual time=98.163..104.122 rows=30 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=16327.31..17285.65 rows=47917 width=59) (actual time=85.154..90.364 rows=10 loops=3)
--                           Group Key: m.name
--                           ->  Sort  (cost=16327.31..16447.10 rows=47917 width=32) (actual time=84.346..85.921 rows=38019 loops=3)
--                                 Sort Key: m.name
--                                 Sort Method: quicksort  Memory: 3863kB
--                                 Worker 0:  Sort Method: quicksort  Memory: 3409kB
--                                 Worker 1:  Sort Method: quicksort  Memory: 3402kB
--                                 ->  Hash Join  (cost=23.84..12602.18 rows=47917 width=32) (actual time=0.561..63.272 rows=38019 loops=3)
--                                       Hash Cond: (t.showtime_id = s.id)
--                                       ->  Parallel Seq Scan on tickets t  (cost=0.00..10536.67 rows=416667 width=9) (actual time=0.058..36.967 rows=333333 loops=3)
--                                             Filter: (price IS NOT NULL)
--                                       ->  Hash  (cost=22.41..22.41 rows=115 width=31) (actual time=0.360..0.362 rows=114 loops=3)
--                                             Buckets: 1024  Batches: 1  Memory Usage: 15kB
--                                             ->  Merge Right Join  (cost=20.28..22.41 rows=115 width=31) (actual time=0.299..0.327 rows=114 loops=3)
--                                                   Merge Cond: (m.id = s.movie_id)
--                                                   ->  Index Scan using movies_pkey on movies m  (cost=0.29..3410.29 rows=100000 width=31) (actual time=0.042..0.046 rows=11 loops=3)
--                                                   ->  Sort  (cost=19.98..20.27 rows=115 width=8) (actual time=0.253..0.260 rows=114 loops=3)
--                                                         Sort Key: s.movie_id
--                                                         Sort Method: quicksort  Memory: 30kB
--                                                         Worker 0:  Sort Method: quicksort  Memory: 30kB
--                                                         Worker 1:  Sort Method: quicksort  Memory: 30kB
--                                                         ->  Bitmap Heap Scan on showtime s  (cost=5.46..16.05 rows=115 width=8) (actual time=0.156..0.205 rows=114 loops=3)
--                                                               Recheck Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time <= CURRENT_DATE))
--                                                               Heap Blocks: exact=8
--                                                               ->  Bitmap Index Scan on idx_sessions_datetime  (cost=0.00..5.43 rows=115 width=0) (actual time=0.125..0.125 rows=114 loops=3)
--                                                                     Index Cond: ((start_time >= (CURRENT_DATE - '7 days'::interval)) AND (start_time <= CURRENT_DATE))
-- Planning Time: 2.078 ms
-- Execution Time: 104.690 ms
