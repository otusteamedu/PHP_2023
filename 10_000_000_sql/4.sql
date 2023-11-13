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
        t.status = 'book' AND (s.datetime::date BETWEEN (CURRENT_DATE - INTERVAL '7 day') AND CURRENT_DATE) AND p.price IS NOT NULL
GROUP BY
    f.name
ORDER BY
    total_price DESC
LIMIT 3;

-- Limit  (cost=120084.38..120084.38 rows=3 width=35) (actual time=405.011..407.251 rows=3 loops=1)
--   ->  Sort  (cost=120084.38..120088.53 rows=1663 width=35) (actual time=390.977..393.217 rows=3 loops=1)
--         Sort Key: (sum(p.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=119867.22..120062.88 rows=1663 width=35) (actual time=386.015..393.057 rows=1191 loops=1)
--               Group Key: f.name
--               ->  Gather Merge  (cost=119867.22..120039.32 rows=1386 width=35) (actual time=385.976..392.543 rows=3572 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=118867.19..118879.32 rows=693 width=35) (actual time=369.314..371.760 rows=1191 loops=3)
--                           Group Key: f.name
--                           ->  Sort  (cost=118867.19..118868.92 rows=693 width=35) (actual time=369.283..370.227 rows=14061 loops=3)
--                                 Sort Key: f.name
--                                 Sort Method: quicksort  Memory: 1314kB
--                                 Worker 0:  Sort Method: quicksort  Memory: 1227kB
--                                 Worker 1:  Sort Method: quicksort  Memory: 1209kB
--                                 ->  Hash Join  (cost=32608.26..118834.49 rows=693 width=35) (actual time=92.362..344.791 rows=14061 loops=3)
--                                       Hash Cond: (t.session_id = s.id)
--                                       ->  Parallel Bitmap Heap Scan on tickets t  (cost=28733.43..109754.82 rows=1386111 width=4) (actual time=66.053..227.842 rows=1110762 loops=3)
--                                             Recheck Cond: (status = 'book'::text)
--                                             Heap Blocks: exact=22391
--                                             ->  Bitmap Index Scan on ticket_book_status  (cost=0.00..27901.76 rows=3326667 width=0) (actual time=76.618..76.618 rows=3332287 loops=1)
--                                       ->  Hash  (cost=3874.20..3874.20 rows=50 width=43) (actual time=26.221..26.224 rows=1264 loops=3)
--                                             Buckets: 2048 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 115kB
--                                             ->  Nested Loop Left Join  (cost=3393.54..3874.20 rows=50 width=43) (actual time=21.095..25.983 rows=1264 loops=3)
--                                                   ->  Hash Join  (cost=3393.25..3583.50 rows=50 width=20) (actual time=21.062..23.019 rows=1264 loops=3)
--                                                         Hash Cond: (p.session_id = s.id)
--                                                         ->  Seq Scan on prices p  (cost=0.00..164.00 rows=10000 width=12) (actual time=9.431..10.165 rows=10000 loops=3)
--                                                               Filter: (price IS NOT NULL)
--                                                         ->  Hash  (cost=3387.00..3387.00 rows=500 width=8) (actual time=11.597..11.598 rows=13456 loops=3)
--                                                               Buckets: 16384 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 654kB
--                                                               ->  Seq Scan on sessions s  (cost=0.00..3387.00 rows=500 width=8) (actual time=0.023..10.091 rows=13456 loops=3)
--                                                                     Filter: (((datetime)::date <= CURRENT_DATE) AND ((datetime)::date >= (CURRENT_DATE - '7 days'::interval)))
--                                                                     Rows Removed by Filter: 86544
--                                                   ->  Index Scan using films_pk on films f  (cost=0.29..5.81 rows=1 width=31) (actual time=0.002..0.002 rows=1 loops=3792)
--                                                         Index Cond: (id = s.film_id)
-- Planning Time: 0.452 ms
-- JIT:
--   Functions: 109
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 3.720 ms, Inlining 0.000 ms, Optimization 1.624 ms, Emission 40.877 ms, Total 46.221 ms"
-- Execution Time: 408.601 ms

create index idx_session_datetime ON sessions((datetime::date));
create index ticket_book_status on tickets (status)
    where status = 'book';

-- Limit  (cost=117348.65..117348.65 rows=3 width=35) (actual time=395.714..398.128 rows=3 loops=1)
--   ->  Sort  (cost=117348.65..117352.80 rows=1663 width=35) (actual time=381.260..383.673 rows=3 loops=1)
--         Sort Key: (sum(p.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=117131.49..117327.15 rows=1663 width=35) (actual time=377.940..383.533 rows=1191 loops=1)
--               Group Key: f.name
--               ->  Gather Merge  (cost=117131.49..117303.59 rows=1386 width=35) (actual time=377.924..383.095 rows=3573 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=116131.46..116143.59 rows=693 width=35) (actual time=364.767..366.654 rows=1191 loops=3)
--                           Group Key: f.name
--                           ->  Sort  (cost=116131.46..116133.19 rows=693 width=35) (actual time=364.738..365.308 rows=14061 loops=3)
--                                 Sort Key: f.name
--                                 Sort Method: quicksort  Memory: 1287kB
--                                 Worker 0:  Sort Method: quicksort  Memory: 1230kB
--                                 Worker 1:  Sort Method: quicksort  Memory: 1233kB
--                                 ->  Hash Join  (cost=29872.53..116098.76 rows=693 width=35) (actual time=85.584..342.239 rows=14061 loops=3)
--                                       Hash Cond: (t.session_id = s.id)
--                                       ->  Parallel Bitmap Heap Scan on tickets t  (cost=28733.43..109754.82 rows=1386111 width=4) (actual time=66.371..231.457 rows=1110762 loops=3)
--                                             Recheck Cond: (status = 'book'::text)
--                                             Heap Blocks: exact=22308
--                                             ->  Bitmap Index Scan on ticket_book_status  (cost=0.00..27901.76 rows=3326667 width=0) (actual time=76.594..76.594 rows=3332287 loops=1)
--                                       ->  Hash  (cost=1138.47..1138.47 rows=50 width=43) (actual time=19.123..19.127 rows=1264 loops=3)
--                                             Buckets: 2048 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 115kB
--                                             ->  Nested Loop Left Join  (cost=657.81..1138.47 rows=50 width=43) (actual time=13.883..18.876 rows=1264 loops=3)
--                                                   ->  Hash Join  (cost=657.52..847.77 rows=50 width=20) (actual time=13.835..15.709 rows=1264 loops=3)
--                                                         Hash Cond: (p.session_id = s.id)
--                                                         ->  Seq Scan on prices p  (cost=0.00..164.00 rows=10000 width=12) (actual time=9.209..9.943 rows=10000 loops=3)
--                                                               Filter: (price IS NOT NULL)
--                                                         ->  Hash  (cost=651.27..651.27 rows=500 width=8) (actual time=4.597..4.598 rows=13456 loops=3)
--                                                               Buckets: 16384 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 654kB
--                                                               ->  Bitmap Heap Scan on sessions s  (cost=9.43..651.27 rows=500 width=8) (actual time=0.449..3.133 rows=13456 loops=3)
--                                                                     Recheck Cond: (((datetime)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((datetime)::date <= CURRENT_DATE))
--                                                                     Heap Blocks: exact=637
--                                                                     ->  Bitmap Index Scan on idx_session_datetime  (cost=0.00..9.30 rows=500 width=0) (actual time=0.382..0.382 rows=13456 loops=3)
--                                                                           Index Cond: (((datetime)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((datetime)::date <= CURRENT_DATE))
--                                                   ->  Index Scan using films_pk on films f  (cost=0.29..5.81 rows=1 width=31) (actual time=0.002..0.002 rows=1 loops=3792)
--                                                         Index Cond: (id = s.film_id)
-- Planning Time: 0.503 ms
-- JIT:
--   Functions: 115
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 4.040 ms, Inlining 0.000 ms, Optimization 1.527 ms, Emission 40.704 ms, Total 46.272 ms"
-- Execution Time: 399.556 ms

--Анализ показал, что добавление индексов существенно не улучшило время выполнения запроса
--Вывод: Создание индексов не оправдано