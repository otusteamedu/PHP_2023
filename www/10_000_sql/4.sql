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

-- Limit  (cost=829.44..829.45 rows=3 width=290) (actual time=2.892..2.894 rows=3 loops=1)
--    ->  Sort  (cost=829.44..830.53 rows=437 width=290) (actual time=2.892..2.893 rows=3 loops=1)
--          Sort Key: (sum(sp.price)) DESC
--          Sort Method: top-N heapsort  Memory: 27kB
--          ->  HashAggregate  (cost=819.42..823.79 rows=437 width=290) (actual time=2.879..2.886 rows=32 loops=1
-- )
--                Group Key: m.id
--                Batches: 1  Memory Usage: 61kB
--                ->  Hash Join  (cost=253.83..817.24 rows=437 width=290) (actual time=1.136..2.865 rows=44 loops
-- =1)
--                      Hash Cond: (s.id = sp.session_id)
--                      ->  Hash Join  (cost=224.28..781.14 rows=436 width=290) (actual time=0.959..2.664 rows=43
-- 4 loops=1)
--                            Hash Cond: (m.id = s.movie_id)
--                            ->  Seq Scan on movies m  (cost=0.00..515.00 rows=10000 width=282) (actual time=0.0
-- 01..0.528 rows=10000 loops=1)
--                            ->  Hash  (cost=218.83..218.83 rows=436 width=12) (actual time=0.955..0.956 rows=43
-- 4 loops=1)
--                                  Buckets: 1024  Batches: 1  Memory Usage: 27kB
--                                  ->  Hash Join  (cost=66.65..218.83 rows=436 width=12) (actual time=0.249..0.9
-- 10 rows=434 loops=1)
--                                        Hash Cond: (t.session_id = s.id)
--                                        ->  Bitmap Heap Scan on tickets t  (cost=37.15..188.19 rows=436 width=4
-- ) (actual time=0.071..0.669 rows=434 loops=1)
--                                              Recheck Cond: (status = 'sold'::bpchar)
--                                              Filter: (date_purchase >= (CURRENT_DATE - '7 days'::interval))
--                                              Rows Removed by Filter: 2918
--                                              Heap Blocks: exact=84
--                                              ->  Bitmap Index Scan on ticket_book_status  (cost=0.00..37.04 ro
-- ws=3352 width=0) (actual time=0.056..0.056 rows=3352 loops=1)
--                                        ->  Hash  (cost=17.00..17.00 rows=1000 width=8) (actual time=0.176..0.1
-- 76 rows=1000 loops=1)
--                                              Buckets: 1024  Batches: 1  Memory Usage: 48kB
--                                              ->  Seq Scan on sessions s  (cost=0.00..17.00 rows=1000 width=8)
-- (actual time=0.003..0.087 rows=1000 loops=1)
--                      ->  Hash  (cost=17.02..17.02 rows=1002 width=12) (actual time=0.166..0.166 rows=1002 loop
-- s=1)
--                            Buckets: 1024  Batches: 1  Memory Usage: 52kB
--                            ->  Seq Scan on session_price sp  (cost=0.00..17.02 rows=1002 width=12) (actual tim
-- e=0.004..0.080 rows=1002 loops=1)
--  Planning Time: 0.385 ms
--  Execution Time: 2.927 ms

create index idx_session_datetime ON sessions((datetime));
create index ticket_sold_status on tickets (status)
    where status = 'sold';

-- Limit  (cost=829.44..829.45 rows=3 width=290) (actual time=2.988..2.990 rows=3 loops=1)
--    ->  Sort  (cost=829.44..830.53 rows=437 width=290) (actual time=2.987..2.989 rows=3 loops=1)
--          Sort Key: (sum(sp.price)) DESC
--          Sort Method: top-N heapsort  Memory: 27kB
--          ->  HashAggregate  (cost=819.42..823.79 rows=437 width=290) (actual time=2.974..2.981 rows=32 loops=1
-- )
--                Group Key: m.id
--                Batches: 1  Memory Usage: 61kB
--                ->  Hash Join  (cost=253.83..817.24 rows=437 width=290) (actual time=1.147..2.958 rows=44 loops
-- =1)
--                      Hash Cond: (s.id = sp.session_id)
--                      ->  Hash Join  (cost=224.28..781.14 rows=436 width=290) (actual time=0.963..2.752 rows=43
-- 4 loops=1)
--                            Hash Cond: (m.id = s.movie_id)
--                            ->  Seq Scan on movies m  (cost=0.00..515.00 rows=10000 width=282) (actual time=0.0
-- 01..0.581 rows=10000 loops=1)
--                            ->  Hash  (cost=218.83..218.83 rows=436 width=12) (actual time=0.958..0.959 rows=43
-- 4 loops=1)
--                                  Buckets: 1024  Batches: 1  Memory Usage: 27kB
--                                  ->  Hash Join  (cost=66.65..218.83 rows=436 width=12) (actual time=0.250..0.9
-- 14 rows=434 loops=1)
--                                        Hash Cond: (t.session_id = s.id)
--                                        ->  Bitmap Heap Scan on tickets t  (cost=37.15..188.19 rows=436 width=4
-- ) (actual time=0.073..0.673 rows=434 loops=1)
--                                              Recheck Cond: (status = 'sold'::bpchar)
--                                              Filter: (date_purchase >= (CURRENT_DATE - '7 days'::interval))
--                                              Rows Removed by Filter: 2918
--                                              Heap Blocks: exact=84
--                                              ->  Bitmap Index Scan on ticket_sold_status  (cost=0.00..37.04 ro
-- ws=3352 width=0) (actual time=0.059..0.059 rows=3352 loops=1)
--                                        ->  Hash  (cost=17.00..17.00 rows=1000 width=8) (actual time=0.175..0.1
-- 75 rows=1000 loops=1)
--                                              Buckets: 1024  Batches: 1  Memory Usage: 48kB
--                                              ->  Seq Scan on sessions s  (cost=0.00..17.00 rows=1000 width=8)
-- (actual time=0.003..0.086 rows=1000 loops=1)
--                      ->  Hash  (cost=17.02..17.02 rows=1002 width=12) (actual time=0.170..0.171 rows=1002 loop
-- s=1)
--                            Buckets: 1024  Batches: 1  Memory Usage: 52kB
--                            ->  Seq Scan on session_price sp  (cost=0.00..17.02 rows=1002 width=12) (actual tim
-- e=0.004..0.082 rows=1002 loops=1)
--  Planning Time: 0.524 ms
--  Execution Time: 3.023 ms