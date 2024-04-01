-- Выбор всех фильмов на сегодня
EXPLAIN ANALYSE
SELECT movies.title
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id;

-- Hash Join  (cost=366923.81..693589.27 rows=10000115 width=18) (actual time=2845.445..8091.302 rows=10000000 loops=1)
--   Hash Cond: (sessions.movie_id = movies.id)
--   ->  Seq Scan on sessions  (cost=0.00..163696.15 rows=10000115 width=4) (actual time=0.032..1096.493 rows=10000000 loops=1)
--   ->  Hash  (cost=183332.58..183332.58 rows=9999858 width=22) (actual time=2818.123..2818.124 rows=10000000 loops=1)
--         Buckets: 65536  Batches: 256  Memory Usage: 2653kB
--         ->  Seq Scan on movies  (cost=0.00..183332.58 rows=9999858 width=22) (actual time=0.011..1165.755 rows=10000000 loops=1)
-- Planning Time: 12.244 ms
-- Execution Time: 8336.922 ms

CREATE INDEX ON sessions (movie_id);

-- Hash Join  (cost=366923.81..693587.82 rows=10000000 width=18) (actual time=2778.354..7859.812 rows=10000000 loops=1)
--   Hash Cond: (sessions.movie_id = movies.id)
--   ->  Seq Scan on sessions  (cost=0.00..163695.00 rows=10000000 width=4) (actual time=0.032..978.249 rows=10000000 loops=1)
--   ->  Hash  (cost=183332.58..183332.58 rows=9999858 width=22) (actual time=2763.551..2763.551 rows=10000000 loops=1)
--         Buckets: 65536  Batches: 256  Memory Usage: 2653kB
--         ->  Seq Scan on movies  (cost=0.00..183332.58 rows=9999858 width=22) (actual time=0.007..1148.754 rows=10000000 loops=1)
-- Planning Time: 0.416 ms
-- Execution Time: 8106.026 ms