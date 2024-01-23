EXPLAIN ANALYZE
SELECT COUNT(st.ID)  as count_tickets
FROM
	seance_tikets AS st
	INNER JOIN seances AS s ON s.ID = st.seance_id 
WHERE
	s."date" >= '2023-12-01' 
	AND s.DATE <= '2023-12-07'
	
/*
Finalize Aggregate  (cost=4502.36..4502.37 rows=1 width=8) (actual time=39.176..40.623 rows=1 loops=1)
  ->  Gather  (cost=4502.25..4502.36 rows=1 width=8) (actual time=38.976..40.616 rows=2 loops=1)
        Workers Planned: 1
        Workers Launched: 1
        ->  Partial Aggregate  (cost=3502.25..3502.26 rows=1 width=8) (actual time=23.310..23.312 rows=1 loops=2)
              ->  Hash Join  (cost=309.05..3310.24 rows=76806 width=4) (actual time=1.332..20.995 rows=65227 loops=2)
                    Hash Cond: (st.seance_id = s.id)
                    ->  Parallel Seq Scan on seance_tikets st  (cost=0.00..2665.24 rows=127924 width=8) (actual time=0.006..10.167 rows=108734 loops=2)
                    ->  Hash  (cost=234.00..234.00 rows=6004 width=4) (actual time=1.257..1.257 rows=6004 loops=2)
                          Buckets: 8192  Batches: 1  Memory Usage: 276kB
                          ->  Seq Scan on seances s  (cost=0.00..234.00 rows=6004 width=4) (actual time=0.011..0.755 rows=6004 loops=2)
                                Filter: ((date >= '2023-12-01'::date) AND (date <= '2023-12-07'::date))
                                Rows Removed by Filter: 3996
Planning Time: 0.273 ms
Execution Time: 40.653 ms
*/

--добавляем индексы
CREATE INDEX seances_date_id_idx ON seances(date);
CREATE INDEX seance_tikets_seance_id_idx ON seance_tikets(seance_id);

/*
Finalize Aggregate  (cost=4483.80..4483.81 rows=1 width=8) (actual time=21.691..23.328 rows=1 loops=1)
  ->  Gather  (cost=4483.69..4483.80 rows=1 width=8) (actual time=21.504..23.323 rows=2 loops=1)
        Workers Planned: 1
        Workers Launched: 1
        ->  Partial Aggregate  (cost=3483.69..3483.70 rows=1 width=8) (actual time=19.408..19.409 rows=1 loops=2)
              ->  Hash Join  (cost=290.52..3291.68 rows=76804 width=4) (actual time=1.717..17.113 rows=65227 loops=2)
                    Hash Cond: (st.seance_id = s.id)
                    ->  Parallel Seq Scan on seance_tikets st  (cost=0.00..2665.22 rows=127922 width=8) (actual time=0.004..5.763 rows=108734 loops=2)
                    ->  Hash  (cost=215.47..215.47 rows=6004 width=4) (actual time=1.655..1.655 rows=6004 loops=2)
                          Buckets: 8192  Batches: 1  Memory Usage: 276kB
                          ->  Index Scan using seances_date_idx on seances s  (cost=0.29..215.47 rows=6004 width=4) (actual time=0.022..1.123 rows=6004 loops=2)
                                Index Cond: ((date >= '2023-12-01'::date) AND (date <= '2023-12-07'::date))
Planning Time: 0.779 ms
Execution Time: 23.357 ms
*/