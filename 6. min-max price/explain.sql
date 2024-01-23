EXPLAIN ANALYZE
SELECT a.seance_id, c.name, b.date, b.time, MAX(a.price), MIN(a.price)
FROM seance_tikets a
JOIN seances b ON b.id=a.seance_id
JOIN films c ON c.id=b.film_id
WHERE a.seance_id=1
GROUP BY a.seance_id, c.name, b.date, b.time

/*
GroupAggregate  (cost=3992.91..3993.51 rows=24 width=596) (actual time=4.443..6.911 rows=1 loops=1)
  Group Key: c.name, b.date, b."time"
  ->  Sort  (cost=3992.91..3992.97 rows=24 width=537) (actual time=4.431..6.900 rows=19 loops=1)
        Sort Key: c.name, b.date, b."time"
        Sort Method: quicksort  Memory: 26kB
        ->  Nested Loop  (cost=1000.43..3992.36 rows=24 width=537) (actual time=0.152..6.889 rows=19 loops=1)
              ->  Nested Loop  (cost=0.43..4.70 rows=1 width=532) (actual time=0.011..0.015 rows=1 loops=1)
                    ->  Index Scan using seances_pkey on seances b  (cost=0.29..2.40 rows=1 width=20) (actual time=0.006..0.009 rows=1 loops=1)
                          Index Cond: (id = 4)
                    ->  Index Scan using films_pkey on films c  (cost=0.14..2.26 rows=1 width=520) (actual time=0.003..0.003 rows=1 loops=1)
                          Index Cond: (id = b.film_id)
              ->  Gather  (cost=1000.00..3987.42 rows=24 width=9) (actual time=0.140..6.870 rows=19 loops=1)
                    Workers Planned: 1
                    Workers Launched: 1
                    ->  Parallel Seq Scan on seance_tikets a  (cost=0.00..2985.02 rows=14 width=9) (actual time=0.622..2.683 rows=10 loops=2)
                          Filter: (seance_id = 4)
                          Rows Removed by Filter: 108724
Planning Time: 0.123 ms
Execution Time: 6.937 ms
*/

CREATE INDEX seance_tikets_seance_id_idx ON seance_tikets(seance_id);
CREATE INDEX seances_film_id_idx ON seances(film_id);

/*
HashAggregate  (cost=8.05..8.29 rows=24 width=596) (actual time=0.030..0.030 rows=1 loops=1)
  Group Key: c.name, b.date, b."time"
  Batches: 1  Memory Usage: 24kB
  ->  Nested Loop  (cost=0.73..7.75 rows=24 width=537) (actual time=0.016..0.020 rows=27 loops=1)
        ->  Nested Loop  (cost=0.43..4.70 rows=1 width=532) (actual time=0.009..0.009 rows=1 loops=1)
              ->  Index Scan using seances_pkey on seances b  (cost=0.29..2.40 rows=1 width=20) (actual time=0.004..0.004 rows=1 loops=1)
                    Index Cond: (id = 1)
              ->  Index Scan using films_pkey on films c  (cost=0.14..2.26 rows=1 width=520) (actual time=0.002..0.002 rows=1 loops=1)
                    Index Cond: (id = b.film_id)
        ->  Index Scan using seance_tikets_seance_id_idx on seance_tikets a  (cost=0.29..2.82 rows=24 width=9) (actual time=0.007..0.009 rows=27 loops=1)
              Index Cond: (seance_id = 1)
Planning Time: 0.178 ms
Execution Time: 0.049 ms
*/