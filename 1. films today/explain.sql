EXPLAIN ANALYSE 
SELECT ID, NAME 
FROM
	films 
WHERE
	ID IN (
	SELECT film_id FROM seances WHERE DATE = '2023-12-03'
)
	
	
/*
Nested Loop  (cost=211.61..217.29 rows=3 width=520) (actual time=0.357..0.360 rows=3 loops=1)
  ->  HashAggregate  (cost=211.45..211.48 rows=3 width=4) (actual time=0.353..0.353 rows=3 loops=1)
        Group Key: seances.film_id
        Batches: 1  Memory Usage: 24kB
        ->  Seq Scan on seances  (cost=0.00..209.00 rows=981 width=4) (actual time=0.003..0.300 rows=981 loops=1)
              Filter: (date = '2023-12-03'::date)
              Rows Removed by Filter: 9019
  ->  Memoize  (cost=0.15..1.92 rows=1 width=520) (actual time=0.002..0.002 rows=1 loops=3)
        Cache Key: seances.film_id
        Cache Mode: logical
        Hits: 0  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
        ->  Index Scan using films_pkey on films  (cost=0.14..1.91 rows=1 width=520) (actual time=0.001..0.001 rows=1 loops=3)
              Index Cond: (id = seances.film_id)
Planning Time: 0.125 ms
Execution Time: 0.372 ms
*/

--добавляем индексы
CREATE INDEX seances_date_idx ON seances(date);


/*
Nested Loop  (cost=109.42..115.10 rows=3 width=520) (actual time=0.235..0.238 rows=3 loops=1)
  ->  HashAggregate  (cost=109.26..109.29 rows=3 width=4) (actual time=0.230..0.231 rows=3 loops=1)
        Group Key: seances.film_id
        Batches: 1  Memory Usage: 24kB
        ->  Index Scan using seances_date_idx on seances  (cost=0.29..106.81 rows=981 width=4) (actual time=0.036..0.175 rows=981 loops=1)
              Index Cond: (date = '2023-12-03'::date)
  ->  Memoize  (cost=0.15..1.92 rows=1 width=520) (actual time=0.002..0.002 rows=1 loops=3)
        Cache Key: seances.film_id
        Cache Mode: logical
        Hits: 0  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
        ->  Index Scan using films_pkey on films  (cost=0.14..1.91 rows=1 width=520) (actual time=0.001..0.001 rows=1 loops=3)
              Index Cond: (id = seances.film_id)
Planning Time: 0.136 ms
Execution Time: 0.251 ms
*/