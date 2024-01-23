EXPLAIN ANALYSE 
SELECT ID, NAME 
FROM
	films 
WHERE
	ID IN (
	SELECT film_id 
	FROM seances 
	WHERE date_unix_ts = extract(epoch from '2023-12-03'::date)
)
/*
Nested Loop  (cost=317.28..322.96 rows=3 width=520) (actual time=1.277..1.281 rows=3 loops=1)
  ->  HashAggregate  (cost=317.12..317.15 rows=3 width=4) (actual time=1.267..1.268 rows=3 loops=1)
        Group Key: seances.film_id
        Batches: 1  Memory Usage: 24kB
        ->  Seq Scan on seances  (cost=0.00..317.00 rows=50 width=4) (actual time=0.038..1.184 rows=981 loops=1)
              Filter: ((date_unix_ts)::numeric = '1701561600'::numeric)
              Rows Removed by Filter: 9019
  ->  Memoize  (cost=0.15..1.92 rows=1 width=520) (actual time=0.004..0.004 rows=1 loops=3)
        Cache Key: seances.film_id
        Cache Mode: logical
        Hits: 0  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
        ->  Index Scan using films_pkey on films  (cost=0.14..1.91 rows=1 width=520) (actual time=0.003..0.003 rows=1 loops=3)
              Index Cond: (id = seances.film_id)
Planning Time: 0.118 ms
Execution Time: 1.302 ms
*/


--добавляем индексы
CREATE INDEX seances_date_unix_ts ON seances(date_unix_ts);

/*
Nested Loop  (cost=317.28..322.96 rows=3 width=520) (actual time=0.728..0.731 rows=3 loops=1)
  ->  HashAggregate  (cost=317.12..317.15 rows=3 width=4) (actual time=0.720..0.721 rows=3 loops=1)
        Group Key: seances.film_id
        Batches: 1  Memory Usage: 24kB
        ->  Seq Scan on seances  (cost=0.00..317.00 rows=50 width=4) (actual time=0.031..0.667 rows=981 loops=1)
              Filter: ((date_unix_ts)::numeric = '1701561600'::numeric)
              Rows Removed by Filter: 9019
  ->  Memoize  (cost=0.15..1.92 rows=1 width=520) (actual time=0.003..0.003 rows=1 loops=3)
        Cache Key: seances.film_id
        Cache Mode: logical
        Hits: 0  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
        ->  Index Scan using films_pkey on films  (cost=0.14..1.91 rows=1 width=520) (actual time=0.002..0.002 rows=1 loops=3)
              Index Cond: (id = seances.film_id)
Planning Time: 0.082 ms
Execution Time: 0.746 ms
*/