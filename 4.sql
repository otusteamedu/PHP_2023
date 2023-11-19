-- Поиск 3 самых прибыльных фильмов за неделю

EXPLAIN ANALYZE
SELECT m.name, SUM(t.price) as price
FROM tickets t
         INNER JOIN sessions s ON t.session_id = s.id
         INNER JOIN movies m ON s.movie_id = m.id
WHERE
    t.status = 1
    AND (t.purchased_at BETWEEN (CURRENT_DATE - INTERVAL '7 day') and CURRENT_DATE)
GROUP BY m.id
ORDER BY price DESC
LIMIT 3;


-----------------------------------------100000------------------------------------------------------
-- QUERY PLAN
-- Limit  (cost=1301.70..1301.71 rows=3 width=23) (actual time=10.362..10.369 rows=3 loops=1)
--    ->  Sort  (cost=1301.70..1302.25 rows=218 width=23) (actual time=10.361..10.366 rows=3 loops=1)
--          Sort Key: (sum(t.price)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  GroupAggregate  (cost=1295.07..1298.89 rows=218 width=23) (actual time=9.647..9.922 rows=340 loops=1)
--                Group Key: m.id
--                ->  Sort  (cost=1295.07..1295.62 rows=218 width=23) (actual time=9.632..9.673 rows=349 loops=1)
--                      Sort Key: m.id
--                      Sort Method: quicksort  Memory: 52kB
--                      ->  Nested Loop  (cost=737.80..1286.60 rows=218 width=23) (actual time=5.197..9.206 rows=349 loops=1)
--                            ->  Hash Join  (cost=737.53..1215.53 rows=218 width=12) (actual time=5.151..8.177 rows=349 loops=1)
--                                  Hash Cond: (s.id = t.session_id)
--                                  ->  Seq Scan on sessions s  (cost=0.00..398.31 rows=21131 width=8) (actual time=0.246..1.653 rows=10000 loops=1)
--                                  ->  Hash  (cost=734.80..734.80 rows=218 width=12) (actual time=4.877..4.879 rows=349 loops=1)
--                                        Buckets: 1024  Batches: 1  Memory Usage: 23kB
--                                        ->  Seq Scan on tickets t  (cost=0.00..734.80 rows=218 width=12) (actual time=0.231..3.474 rows=349 loops=1)
--                                              Filter: ((status = 1) AND (purchased_at <= CURRENT_DATE) AND (purchased_at >= (CURRENT_DATE - '7 days'::interval)))
--                                              Rows Removed by Filter: 9651
--                            ->  Index Scan using movies_pkey on movies m  (cost=0.28..0.33 rows=1 width=15) (actual time=0.002..0.002 rows=1 loops=349)
--                                  Index Cond: (id = s.movie_id)
--  Planning Time: 0.717 ms
--  Execution Time: 10.596 ms
-- (22 rows)


-----------------------------------------10000000----------------------------------------------------
-- QUERY PLAN
-- Limit  (cost=188517.49..188517.50 rows=1 width=23) (actual time=1430.752..1438.337 rows=3 loops=1)
--    ->  Sort  (cost=188517.49..188517.50 rows=1 width=23) (actual time=1407.512..1415.095 rows=3 loops=1)
--          Sort Key: (sum(t.price)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  GroupAggregate  (cost=188517.46..188517.48 rows=1 width=23) (actual time=1407.222..1414.982 rows=253 loops=1)
--                Group Key: m.id
--                ->  Sort  (cost=188517.46..188517.47 rows=1 width=23) (actual time=1407.163..1414.776 rows=253 loops=1)
--                      Sort Key: m.id
--                      Sort Method: quicksort  Memory: 44kB
--                      ->  Nested Loop  (cost=1000.59..188517.45 rows=1 width=23) (actual time=1404.613..1414.592 rows=253 loops=1)
--                            ->  Nested Loop  (cost=1000.29..188517.08 rows=1 width=12) (actual time=1404.593..1413.789 rows=253 loops=1)
--                                  ->  Gather  (cost=1000.00..188508.77 rows=1 width=12) (actual time=1404.525..1412.820 rows=253 loops=1)
--                                        Workers Planned: 2
--                                        Workers Launched: 2
--                                        ->  Parallel Seq Scan on tickets t  (cost=0.00..187508.67 rows=1 width=12) (actual time=1364.893..1364.957 rows=84 loops=3)
--                                              Filter: ((status = 1) AND (purchased_at <= CURRENT_DATE) AND (purchased_at >= (CURRENT_DATE - '7 days'::interval)))
--                                              Rows Removed by Filter: 3333249
--                                  ->  Index Scan using sessions_pkey on sessions s  (cost=0.29..8.31 rows=1 width=8) (actual time=0.003..0.003 rows=1 loops=253)
--                                        Index Cond: (id = t.session_id)
--                            ->  Index Scan using movies_pkey on movies m  (cost=0.29..0.37 rows=1 width=15) (actual time=0.003..0.003 rows=1 loops=253)
--                                  Index Cond: (id = s.movie_id)
--  Planning Time: 0.964 ms
--  JIT:
--    Functions: 28
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 8.107 ms, Inlining 0.000 ms, Optimization 1.746 ms, Emission 38.521 ms, Total 48.374 ms
--  Execution Time: 1444.802 ms
-- (27 rows)

CREATE INDEX tickets_status_purchased_at ON tickets USING btree(status, purchased_at);

-----------------------------------------100000------------------------------------------------------
-- QUERY PLAN
-- Limit  (cost=651.79..651.80 rows=3 width=23) (actual time=2.439..2.441 rows=3 loops=1)
--    ->  Sort  (cost=651.79..652.03 rows=96 width=23) (actual time=2.437..2.439 rows=3 loops=1)
--          Sort Key: (sum(t.price)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  GroupAggregate  (cost=648.87..650.55 rows=96 width=23) (actual time=2.207..2.365 rows=340 loops=1)
--                Group Key: m.id
--                ->  Sort  (cost=648.87..649.11 rows=96 width=23) (actual time=2.199..2.223 rows=349 loops=1)
--                      Sort Key: m.id
--                      Sort Method: quicksort  Memory: 52kB
--                      ->  Nested Loop  (cost=6.08..645.71 rows=96 width=23) (actual time=0.106..2.017 rows=349 loops=1)
--                            ->  Nested Loop  (cost=5.80..614.41 rows=96 width=12) (actual time=0.087..1.215 rows=349 loops=1)
--                                  ->  Bitmap Heap Scan on tickets t  (cost=5.52..157.13 rows=96 width=12) (actual time=0.064..0.258 rows=349 loops=1)
--                                        Recheck Cond: ((status = 1) AND (purchased_at >= (CURRENT_DATE - '7 days'::interval)) AND (purchased_at <= CURRENT_DATE))
--                                        Heap Blocks: exact=83
--                                        ->  Bitmap Index Scan on tickets_status_purchased_at_idx  (cost=0.00..5.49 rows=96 width=0) (actual time=0.043..0.044 rows=349 loops=1)
--                                              Index Cond: ((status = 1) AND (purchased_at >= (CURRENT_DATE - '7 days'::interval)) AND (purchased_at <= CURRENT_DATE))
--                                  ->  Index Scan using sessions_pkey on sessions s  (cost=0.29..4.76 rows=1 width=8) (actual time=0.002..0.002 rows=1 loops=349)
--                                        Index Cond: (id = t.session_id)
--                            ->  Index Scan using movies_pkey on movies m  (cost=0.28..0.33 rows=1 width=15) (actual time=0.002..0.002 rows=1 loops=349)
--                                  Index Cond: (id = s.movie_id)
--  Planning Time: 0.623 ms
--  Execution Time: 2.599 ms
-- (22 rows)


-----------------------------------------10000000----------------------------------------------------
-- QUERY PLAN
-- Limit  (cost=17.19..17.19 rows=1 width=23) (actual time=3.228..3.230 rows=3 loops=1)
--    ->  Sort  (cost=17.19..17.19 rows=1 width=23) (actual time=3.226..3.228 rows=3 loops=1)
--          Sort Key: (sum(t.price)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  GroupAggregate  (cost=17.16..17.18 rows=1 width=23) (actual time=3.051..3.167 rows=253 loops=1)
--                Group Key: m.id
--                ->  Sort  (cost=17.16..17.16 rows=1 width=23) (actual time=3.043..3.061 rows=253 loops=1)
--                      Sort Key: m.id
--                      Sort Method: quicksort  Memory: 44kB
--                      ->  Nested Loop  (cost=1.03..17.15 rows=1 width=23) (actual time=0.079..2.588 rows=253 loops=1)
--                            ->  Nested Loop  (cost=0.73..16.78 rows=1 width=12) (actual time=0.058..1.705 rows=253 loops=1)
--                                  ->  Index Scan using tickets_status_purchased_at on tickets t  (cost=0.44..8.46 rows=1 width=12) (actual time=0.034..0.118 rows=253 loops=1)
--                                        Index Cond: ((status = 1) AND (purchased_at >= (CURRENT_DATE - '7 days'::interval)) AND (purchased_at <= CURRENT_DATE))
--                                  ->  Index Scan using sessions_pkey on sessions s  (cost=0.29..8.31 rows=1 width=8) (actual time=0.006..0.006 rows=1 loops=253)
--                                        Index Cond: (id = t.session_id)
--                            ->  Index Scan using movies_pkey on movies m  (cost=0.29..0.37 rows=1 width=15) (actual time=0.003..0.003 rows=1 loops=253)
--                                  Index Cond: (id = s.movie_id)
--  Planning Time: 2.625 ms
--  Execution Time: 3.365 ms
-- (19 rows)
