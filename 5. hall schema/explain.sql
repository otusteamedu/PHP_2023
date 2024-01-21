EXPLAIN ANALYZE
SELECT a.seat_num, a.row, a.col,
  CASE
    WHEN c.id IS NOT NULL THEN 'BUSY'
    ELSE 'FREE'
  END as seat_type
FROM halls_seat_schema a
JOIN seances b on b.hall_id=a.hall_id
LEFT JOIN seance_tikets c ON c.seance_id=b.id and c.seat_num=a.seat_num
where b.id=3


/*
Hash Right Join  (cost=1005.26..3992.97 rows=30 width=40) (actual time=0.141..12.301 rows=40 loops=1)
  Hash Cond: (c.seat_num = a.seat_num)
  ->  Gather  (cost=1000.00..3987.42 rows=24 width=12) (actual time=0.115..12.264 rows=37 loops=1)
        Workers Planned: 1
        Workers Launched: 1
        ->  Parallel Seq Scan on seance_tikets c  (cost=0.00..2985.02 rows=14 width=12) (actual time=1.282..6.141 rows=18 loops=2)
              Filter: (seance_id = 3)
              Rows Removed by Filter: 108715
  ->  Hash  (cost=4.88..4.88 rows=30 width=12) (actual time=0.022..0.025 rows=40 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 10kB
        ->  Hash Join  (cost=2.42..4.88 rows=30 width=12) (actual time=0.015..0.022 rows=40 loops=1)
              Hash Cond: (a.hall_id = b.hall_id)
              ->  Seq Scan on halls_seat_schema a  (cost=0.00..1.90 rows=90 width=12) (actual time=0.002..0.005 rows=90 loops=1)
              ->  Hash  (cost=2.40..2.40 rows=1 width=8) (actual time=0.007..0.008 rows=1 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 9kB
                    ->  Index Scan using seances_pkey on seances b  (cost=0.29..2.40 rows=1 width=8) (actual time=0.005..0.006 rows=1 loops=1)
                          Index Cond: (id = 3)
Planning Time: 0.130 ms
Execution Time: 12.320 ms
*/

CREATE INDEX halls_seat_schema_hall_id_idx ON halls_seat_schema(hall_id);
CREATE INDEX seances_hall_id_idx ON seances(hall_id);
CREATE INDEX seance_tikets_seance_id_idx ON seance_tikets(seance_id)
CREATE INDEX seance_tikets_seat_num_idx ON seance_tikets(seat_num)

/*
Hash Right Join  (cost=5.55..8.37 rows=30 width=40) (actual time=0.061..0.073 rows=40 loops=1)
  Hash Cond: (c.seat_num = a.seat_num)
  ->  Index Scan using seance_tikets_seance_id_idx on seance_tikets c  (cost=0.29..2.82 rows=24 width=12) (actual time=0.019..0.022 rows=37 loops=1)
        Index Cond: (seance_id = 3)
  ->  Hash  (cost=4.88..4.88 rows=30 width=12) (actual time=0.037..0.038 rows=40 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 10kB
        ->  Hash Join  (cost=2.42..4.88 rows=30 width=12) (actual time=0.027..0.034 rows=40 loops=1)
              Hash Cond: (a.hall_id = b.hall_id)
              ->  Seq Scan on halls_seat_schema a  (cost=0.00..1.90 rows=90 width=12) (actual time=0.007..0.010 rows=90 loops=1)
              ->  Hash  (cost=2.40..2.40 rows=1 width=8) (actual time=0.012..0.012 rows=1 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 9kB
                    ->  Index Scan using seances_pkey on seances b  (cost=0.29..2.40 rows=1 width=8) (actual time=0.009..0.010 rows=1 loops=1)
                          Index Cond: (id = 3)
Planning Time: 0.584 ms
Execution Time: 0.121 ms
*/
