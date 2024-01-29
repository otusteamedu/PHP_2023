EXPLAIN ANALYSE
SELECT
    m.name AS movie_name,
    SUM(sp.price) AS total_revenue
FROM
    public.movies m
        JOIN
    public.sessions s ON m.id = s.movie_id
        JOIN
    public.session_price sp ON s.id = sp.session_id
        LEFT JOIN
    public.tickets t ON s.id = t.session_id AND t.status = 'sold'
WHERE
    t.date_purchase >= current_date - interval '7 days'
GROUP BY
    m.id
ORDER BY
    total_revenue DESC
    LIMIT 3;

-- Limit  (cost=9916.05..9916.06 rows=3 width=290) (actual time=48.708..48.713 rows=3 loops=1)
--    ->  Sort  (cost=9916.05..9927.98 rows=4770 width=290) (actual time=48.708..48.711 rows=3 loops=1)
--          Sort Key: (sum(sp.price)) DESC
--          Sort Method: top-N heapsort  Memory: 28kB
--          ->  GroupAggregate  (cost=7624.81..9854.40 rows=4770 width=290) (actual time=37.844..48.273 rows=3641
--  loops=1)
--                Group Key: m.id
--                ->  Merge Join  (cost=7624.81..9782.85 rows=4770 width=290) (actual time=37.837..46.559 rows=14
-- 302 loops=1)
--                      Merge Cond: (m.id = s.movie_id)
--                      ->  Index Scan using movies_pkey on movies m  (cost=0.29..7417.29 rows=110000 width=282)
-- (actual time=0.005..4.734 rows=29999 loops=1)
--                      ->  Sort  (cost=7624.52..7636.44 rows=4770 width=12) (actual time=37.819..38.559 rows=143
-- 02 loops=1)
--                            Sort Key: s.movie_id
--                            Sort Method: quicksort  Memory: 943kB
--                            ->  Hash Join  (cost=5252.60..7333.08 rows=4770 width=12) (actual time=22.001..35.5
-- 77 rows=14302 loops=1)
--                                  Hash Cond: (sp.session_id = s.id)
--                                  ->  Seq Scan on session_price sp  (cost=0.00..1654.02 rows=101002 width=12) (
-- actual time=0.004..4.530 rows=101002 loops=1)
--                                  ->  Hash  (cost=5192.97..5192.97 rows=4770 width=12) (actual time=21.981..21.
-- 983 rows=4722 loops=1)
--                                        Buckets: 8192  Batches: 1  Memory Usage: 267kB
--                                        ->  Merge Join  (cost=3520.72..5192.97 rows=4770 width=12) (actual time
-- =13.403..21.418 rows=4722 loops=1)
--                                              Merge Cond: (s.id = t.session_id)
--                                              ->  Index Scan using sessions_pkey on sessions s  (cost=0.29..328
-- 2.29 rows=101000 width=8) (actual time=0.010..4.666 rows=46001 loops=1)
--                                              ->  Sort  (cost=3520.42..3532.35 rows=4770 width=4) (actual time=
-- 13.386..13.605 rows=4722 loops=1)
--                                                    Sort Key: t.session_id
--                                                    Sort Method: quicksort  Memory: 193kB
--                                                    ->  Seq Scan on tickets t  (cost=0.00..3228.98 rows=4770 wi
-- dth=4) (actual time=0.005..12.967 rows=4722 loops=1)
--                                                          Filter: ((status = 'sold'::bpchar) AND (date_purchase
--  >= (CURRENT_DATE - '7 days'::interval)))
--                                                          Rows Removed by Filter: 105277
--  Planning Time: 0.365 ms
--  Execution Time: 48.746 ms

create index idx_session_datetime ON sessions((datetime));
create index ticket_sold_status on tickets (status)
    where status = 'sold';

-- Limit  (cost=8768.65..8768.66 rows=3 width=290) (actual time=42.829..42.833 rows=3 loops=1)
--    ->  Sort  (cost=8768.65..8780.58 rows=4770 width=290) (actual time=42.827..42.831 rows=3 loops=1)
--          Sort Key: (sum(sp.price)) DESC
--          Sort Method: top-N heapsort  Memory: 28kB
--          ->  GroupAggregate  (cost=6477.42..8707.00 rows=4770 width=290) (actual time=31.790..42.384 rows=3641
--  loops=1)
--                Group Key: m.id
--                ->  Merge Join  (cost=6477.42..8635.45 rows=4770 width=290) (actual time=31.782..40.577 rows=14
-- 302 loops=1)
--                      Merge Cond: (m.id = s.movie_id)
--                      ->  Index Scan using movies_pkey on movies m  (cost=0.29..7417.29 rows=110000 width=282)
-- (actual time=0.005..4.746 rows=29999 loops=1)
--                      ->  Sort  (cost=6477.12..6489.04 rows=4770 width=12) (actual time=31.764..32.589 rows=143
-- 02 loops=1)
--                            Sort Key: s.movie_id
--                            Sort Method: quicksort  Memory: 943kB
--                            ->  Hash Join  (cost=4105.20..6185.68 rows=4770 width=12) (actual time=16.264..29.7
-- 66 rows=14302 loops=1)
--                                  Hash Cond: (sp.session_id = s.id)
--                                  ->  Seq Scan on session_price sp  (cost=0.00..1654.02 rows=101002 width=12) (
-- actual time=0.003..4.489 rows=101002 loops=1)
--                                  ->  Hash  (cost=4045.58..4045.58 rows=4770 width=12) (actual time=16.246..16.
-- 248 rows=4722 loops=1)
--                                        Buckets: 8192  Batches: 1  Memory Usage: 267kB
--                                        ->  Merge Join  (cost=2373.32..4045.58 rows=4770 width=12) (actual time
-- =8.075..15.767 rows=4722 loops=1)
--                                              Merge Cond: (s.id = t.session_id)
--                                              ->  Index Scan using sessions_pkey on sessions s  (cost=0.29..328
-- 2.29 rows=101000 width=8) (actual time=0.004..4.397 rows=46001 loops=1)
--                                              ->  Sort  (cost=2373.02..2384.95 rows=4770 width=4) (actual time=
-- 8.065..8.245 rows=4722 loops=1)
--                                                    Sort Key: t.session_id
--                                                    Sort Method: quicksort  Memory: 193kB
--                                                    ->  Bitmap Heap Scan on tickets t  (cost=320.50..2081.58 ro
-- ws=4770 width=4) (actual time=0.812..7.646 rows=4722 loops=1)
--                                                          Recheck Cond: (status = 'sold'::bpchar)
--                                                          Filter: (date_purchase >= (CURRENT_DATE - '7 days'::i
-- nterval))
--                                                          Rows Removed by Filter: 32028
--                                                          Heap Blocks: exact=1029
--                                                          ->  Bitmap Index Scan on ticket_sold_status  (cost=0.
-- 00..319.31 rows=36604 width=0) (actual time=0.714..0.714 rows=36750 loops=1)
--  Planning Time: 0.477 ms
--  Execution Time: 42.874 ms