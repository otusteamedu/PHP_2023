EXPLAIN ANALYZE
SELECT
	f.ID, f.NAME, h.NAME AS hall_name,s.DATE, s.TIME 
FROM
	films AS f
	JOIN seances AS s ON s.film_id = f.
	ID JOIN halls AS h ON h.ID = s.hall_id 
WHERE
	s.DATE = '2023-12-03' 
ORDER BY
	s.TIME
	
/*
Sort  (cost=289.35..291.80 rows=981 width=1048) (actual time=0.645..0.670 rows=981 loops=1)
  Sort Key: s."time"
  Sort Method: quicksort  Memory: 98kB
  ->  Hash Join  (cost=26.30..240.61 rows=981 width=1048) (actual time=0.016..0.495 rows=981 loops=1)
        Hash Cond: (s.hall_id = h.id)
        ->  Hash Join  (cost=13.15..224.80 rows=981 width=536) (actual time=0.009..0.419 rows=981 loops=1)
              Hash Cond: (s.film_id = f.id)
              ->  Seq Scan on seances s  (cost=0.00..209.00 rows=981 width=20) (actual time=0.003..0.335 rows=981 loops=1)
                    Filter: (date = '2023-12-03'::date)
                    Rows Removed by Filter: 9019
              ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.003..0.004 rows=13 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 9kB
                    ->  Seq Scan on films f  (cost=0.00..11.40 rows=140 width=520) (actual time=0.001..0.002 rows=13 loops=1)
        ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.006..0.006 rows=3 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 9kB
              ->  Seq Scan on halls h  (cost=0.00..11.40 rows=140 width=520) (actual time=0.003..0.004 rows=3 loops=1)
Planning Time: 0.096 ms
Execution Time: 0.700 ms
*/	

--добавляем индексы
CREATE INDEX seances_date_id_idx ON seances(date);
CREATE INDEX seances_hall_id_idx ON seances(hall_id);
CREATE INDEX seances_film_id_idx ON seances(film_id);



/*
Sort  (cost=187.16..189.61 rows=981 width=1048) (actual time=0.545..0.574 rows=981 loops=1)
  Sort Key: s."time"
  Sort Method: quicksort  Memory: 98kB
  ->  Hash Join  (cost=26.59..138.42 rows=981 width=1048) (actual time=0.033..0.377 rows=981 loops=1)
        Hash Cond: (s.hall_id = h.id)
        ->  Hash Join  (cost=13.44..122.61 rows=981 width=536) (actual time=0.014..0.253 rows=981 loops=1)
              Hash Cond: (s.film_id = f.id)
              ->  Index Scan using seances_date_id_idx on seances s  (cost=0.29..106.81 rows=981 width=20) (actual time=0.008..0.147 rows=981 loops=1)
                    Index Cond: (date = '2023-12-03'::date)
              ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.004..0.004 rows=13 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 9kB
                    ->  Seq Scan on films f  (cost=0.00..11.40 rows=140 width=520) (actual time=0.002..0.002 rows=13 loops=1)
        ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.006..0.007 rows=3 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 9kB
              ->  Seq Scan on halls h  (cost=0.00..11.40 rows=140 width=520) (actual time=0.004..0.004 rows=3 loops=1)
Planning Time: 0.231 ms
Execution Time: 0.610 ms
*/