--Поиск 3 самых прибыльных фильмов за неделю
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
        t.status = 'book' AND (s.datetime BETWEEN (CURRENT_DATE - INTERVAL '7 day') AND CURRENT_DATE) AND p.price IS NOT NULL
GROUP BY
    f.name
ORDER BY
    total_price DESC
LIMIT 3;

-- Limit  (cost=132960.01..132960.02 rows=3 width=35) (actual time=406.076..410.376 rows=3 loops=1)
--   ->  Sort  (cost=132960.01..133061.88 rows=40745 width=35) (actual time=391.968..396.268 rows=3 loops=1)
--         Sort Key: (sum(p.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=127639.94..132433.39 rows=40745 width=35) (actual time=388.704..396.123 rows=1079 loops=1)
--               Group Key: f.name
--               ->  Gather Merge  (cost=127639.94..131856.17 rows=33954 width=35) (actual time=388.694..395.713 rows=3237 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=126639.92..126937.01 rows=16977 width=35) (actual time=374.738..376.547 rows=1079 loops=3)
--                           Group Key: f.name
--                           ->  Sort  (cost=126639.92..126682.36 rows=16977 width=35) (actual time=374.706..375.283 rows=12785 loops=3)
--                                 Sort Key: f.name
--                                 Sort Method: quicksort  Memory: 1214kB
--                                 Worker 0:  Sort Method: quicksort  Memory: 1149kB
--                                 Worker 1:  Sort Method: quicksort  Memory: 1148kB
--                                 ->  Hash Join  (cost=4301.12..125447.17 rows=16977 width=35) (actual time=24.513..353.374 rows=12785 loops=3)
--                                       Hash Cond: (t.session_id = s.id)
--                                       ->  Parallel Seq Scan on tickets t  (cost=0.00..115778.33 rows=1386111 width=4) (actual time=9.937..267.878 rows=1110762 loops=3)
--                                             Filter: (status = 'book'::text)
--                                             Rows Removed by Filter: 2222571
--                                       ->  Hash  (cost=4285.81..4285.81 rows=1225 width=43) (actual time=14.506..14.509 rows=1150 loops=3)
--                                             Buckets: 2048  Batches: 1  Memory Usage: 106kB
--                                             ->  Nested Loop Left Join  (cost=3040.39..4285.81 rows=1225 width=43) (actual time=9.861..14.103 rows=1150 loops=3)
--                                                   ->  Hash Join  (cost=3040.10..3230.35 rows=1225 width=20) (actual time=9.839..11.613 rows=1150 loops=3)
--                                                         Hash Cond: (p.session_id = s.id)
--                                                         ->  Seq Scan on prices p  (cost=0.00..164.00 rows=10000 width=12) (actual time=0.023..0.752 rows=10000 loops=3)
--                                                               Filter: (price IS NOT NULL)
--                                                         ->  Hash  (cost=2887.00..2887.00 rows=12248 width=8) (actual time=9.751..9.752 rows=11753 loops=3)
--                                                               Buckets: 16384  Batches: 1  Memory Usage: 588kB
--                                                               ->  Seq Scan on sessions s  (cost=0.00..2887.00 rows=12248 width=8) (actual time=0.017..8.187 rows=11753 loops=3)
--                                                                     Filter: ((datetime <= CURRENT_DATE) AND (datetime >= (CURRENT_DATE - '7 days'::interval)))
--                                                                     Rows Removed by Filter: 88247
--                                                   ->  Index Scan using films_pk on films f  (cost=0.29..0.86 rows=1 width=31) (actual time=0.002..0.002 rows=1 loops=3450)
--                                                         Index Cond: (id = s.film_id)
-- Planning Time: 0.415 ms
-- JIT:
--   Functions: 109
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 3.520 ms, Inlining 0.000 ms, Optimization 1.543 ms, Emission 42.445 ms, Total 47.508 ms"
-- Execution Time: 411.607 ms

create index idx_session_datetime ON sessions((datetime));
create index ticket_book_status on tickets (status)
    where status = 'book';

-- Limit  (cost=123464.98..123464.99 rows=3 width=35) (actual time=372.152..376.291 rows=3 loops=1)
--   ->  Sort  (cost=123464.98..123566.84 rows=40745 width=35) (actual time=357.029..361.167 rows=3 loops=1)
--         Sort Key: (sum(p.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize HashAggregate  (cost=122530.91..122938.36 rows=40745 width=35) (actual time=356.642..361.038 rows=1079 loops=1)
--               Group Key: f.name
--               Batches: 1  Memory Usage: 1681kB
--               ->  Gather  (cost=118795.97..122361.14 rows=33954 width=35) (actual time=355.289..360.068 rows=3237 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial HashAggregate  (cost=117795.97..117965.74 rows=16977 width=35) (actual time=341.027..341.234 rows=1079 loops=3)
--                           Group Key: f.name
--                           Batches: 1  Memory Usage: 913kB
--                           Worker 0:  Batches: 1  Memory Usage: 913kB
--                           Worker 1:  Batches: 1  Memory Usage: 913kB
--                           ->  Hash Join  (cost=31321.98..117711.08 rows=16977 width=35) (actual time=77.752..334.700 rows=12785 loops=3)
--                                 Hash Cond: (t.session_id = s.id)
--                                 ->  Parallel Bitmap Heap Scan on tickets t  (cost=28733.43..109754.82 rows=1386111 width=4) (actual time=59.080..226.023 rows=1110762 loops=3)
--                                       Recheck Cond: (status = 'book'::text)
--                                       Heap Blocks: exact=22425
--                                       ->  Bitmap Index Scan on ticket_book_status  (cost=0.00..27901.76 rows=3326667 width=0) (actual time=73.414..73.414 rows=3332287 loops=1)
--                                 ->  Hash  (cost=2573.23..2573.23 rows=1225 width=43) (actual time=18.579..18.582 rows=1150 loops=3)
--                                       Buckets: 2048  Batches: 1  Memory Usage: 106kB
--                                       ->  Nested Loop Left Join  (cost=1327.81..2573.23 rows=1225 width=43) (actual time=13.814..18.347 rows=1150 loops=3)
--                                             ->  Hash Join  (cost=1327.52..1517.77 rows=1225 width=20) (actual time=13.791..15.627 rows=1150 loops=3)
--                                                   Hash Cond: (p.session_id = s.id)
--                                                   ->  Seq Scan on prices p  (cost=0.00..164.00 rows=10000 width=12) (actual time=8.921..9.629 rows=10000 loops=3)
--                                                         Filter: (price IS NOT NULL)
--                                                   ->  Hash  (cost=1174.42..1174.42 rows=12248 width=8) (actual time=4.823..4.824 rows=11753 loops=3)
--                                                         Buckets: 16384  Batches: 1  Memory Usage: 588kB
--                                                         ->  Bitmap Heap Scan on sessions s  (cost=261.84..1174.42 rows=12248 width=8) (actual time=0.674..3.542 rows=11753 loops=3)
--                                                               Recheck Cond: ((datetime >= (CURRENT_DATE - '7 days'::interval)) AND (datetime <= CURRENT_DATE))
--                                                               Heap Blocks: exact=637
--                                                               ->  Bitmap Index Scan on idx_session_datetime  (cost=0.00..258.78 rows=12248 width=0) (actual time=0.594..0.594 rows=11753 loops=3)
--                                                                     Index Cond: ((datetime >= (CURRENT_DATE - '7 days'::interval)) AND (datetime <= CURRENT_DATE))
--                                             ->  Index Scan using films_pk on films f  (cost=0.29..0.86 rows=1 width=31) (actual time=0.002..0.002 rows=1 loops=3450)
--                                                   Index Cond: (id = s.film_id)
-- Planning Time: 0.631 ms
-- JIT:
--   Functions: 117
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 3.545 ms, Inlining 0.000 ms, Optimization 1.622 ms, Emission 40.450 ms, Total 45.617 ms"
-- Execution Time: 377.755 ms

--Анализ показал, что добавление индексов существенно не улучшило время выполнения запроса
--Вывод: Создание индексов не оправдано