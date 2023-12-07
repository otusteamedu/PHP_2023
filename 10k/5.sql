--Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
EXPLAIN ANALYSE
SELECT sih.row,
       sih.seats,
       CASE WHEN t.id is NOT NULL THEN 1 ELSE 0 END AS busy
from seats_in_halls as sih
         LEFT JOIN tickets as t on t.seat_in_hall_id = sih.id
where sih.hall_id = 1
    and t.showtime_id = 1
   or t.id is null;

-- Hash Right Join  (cost=55.90..233.08 rows=45 width=8) (actual time=0.863..4.669 rows=9 loops=1)
--   Hash Cond: (t.seat_in_hall_id = sih.id)
--   Filter: (((sih.hall_id = 1) AND (t.showtime_id = 1)) OR (t.id IS NULL))
--   Rows Removed by Filter: 9991
--   ->  Seq Scan on tickets t  (cost=0.00..153.60 rows=8960 width=12) (actual time=0.010..1.348 rows=10000 loops=1)
--   ->  Hash  (cost=30.40..30.40 rows=2040 width=12) (actual time=0.589..0.591 rows=1000 loops=1)
--         Buckets: 2048  Batches: 1  Memory Usage: 59kB
--         ->  Seq Scan on seats_in_halls sih  (cost=0.00..30.40 rows=2040 width=12) (actual time=0.043..0.235 rows=1000 loops=1)
-- Planning Time: 0.484 ms
-- Execution Time: 4.805 ms

create index idx_sessions_datetime on showtime (start_time);

-- Hash Right Join  (cost=55.90..233.08 rows=45 width=8) (actual time=3.831..7.190 rows=9 loops=1)
--   Hash Cond: (t.seat_in_hall_id = sih.id)
--   Filter: (((sih.hall_id = 1) AND (t.showtime_id = 1)) OR (t.id IS NULL))
--   Rows Removed by Filter: 9991
--   ->  Seq Scan on tickets t  (cost=0.00..153.60 rows=8960 width=12) (actual time=0.013..1.097 rows=10000 loops=1)
--   ->  Hash  (cost=30.40..30.40 rows=2040 width=12) (actual time=3.548..3.549 rows=1000 loops=1)
--         Buckets: 2048  Batches: 1  Memory Usage: 59kB
--         ->  Seq Scan on seats_in_halls sih  (cost=0.00..30.40 rows=2040 width=12) (actual time=0.023..0.237 rows=1000 loops=1)
-- Planning Time: 0.209 ms
-- Execution Time: 7.326 ms
